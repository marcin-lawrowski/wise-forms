<?php

/**
 * WiseForms form shortcode.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsFormShortcode extends WiseFormsShortcode {

	/**
	 * @var WiseFormsFormDAO
	 */
	private $formsDao;

	/**
	 * @var WiseFormsResultDAO
	 */
	private $resultsDao;

	private static $instanceId = 0;

	public function __construct() {
		WiseFormsContainer::load('fields/WiseFormsFieldsUtils');
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');
		$this->resultsDao = WiseFormsContainer::get('dao/WiseFormsResultDAO');
	}

	public function render($attributes) {
		if (!is_array($attributes) || !array_key_exists('id', $attributes)) {
			return '<!-- Wise Forms: not "id" parameter specified -->';
		}

		$form = $this->formsDao->getById(intval($attributes['id']));
		if ($form === null) {
			return '<!-- Wise Forms: form does not exist -->';
		}

		// increase instance ID:
		self::$instanceId++;

		// process form sending:
		$submitted = false;
		$errors = array();
		if ($this->hasPostParam('wfSendForm')) {
			$formPublicId = $this->getPostParam('wfSendForm');
			$formInstanceIdEncrypted = $this->getPostParam('wfSendFormInstance');
			$formId = WiseFormsCrypt::decrypt(base64_decode($formPublicId));
			$formInstanceId = WiseFormsCrypt::decrypt(base64_decode($formInstanceIdEncrypted));

			if ($formId == $form->getId() && $formInstanceId == self::$instanceId) {
				$errors = $this->validateForm($form);
				if (count($errors) === 0) {
					$result = $this->processForm($form);
					$this->sendNotifications($form, $result);
					$submitted = true;
				}
			}
		}

		$fieldsConfiguration = json_decode($form->getFields(), true);

		return $this->renderView('form/templates/FormShortcode', array(
			'form' => $form,
			'formPublicId' => base64_encode(WiseFormsCrypt::encrypt($form->getId())),
			'formInstanceId' => base64_encode(WiseFormsCrypt::encrypt(self::$instanceId)),
			'submitted' => $submitted,
			'hasErrors' => count($errors) > 0,
			'errors' => $errors,
			'fieldsRendered' => !$submitted ? $this->renderFields($fieldsConfiguration, $errors) : ''
		));
	}

	private function renderFields($fields, $errors) {
		if (!is_array($fields)) {
			return '<!-- Wise Forms: fields configuration is broken -->';
		}

		$html = '';
		foreach ($fields as $field) {
			if (!is_array($field)) {
				continue;
			}

			$fieldRendered = '';
			if (array_key_exists('children', $field)) {
				$children = array();
				foreach ($field['children'] as $childrenFields) {
					$children[] = $this->renderFields($childrenFields, $errors);
				}

				$fieldRendered = $this->renderView('form/templates/fields/' . ucfirst($field['type']), array_merge(
					array(
						'childrenRendered' => $children,
					),
					$field
				));
			} else {
				$processor = $this->getFieldProcessor($field);
				$fieldRendered = $this->renderView('form/templates/fields/' . ucfirst($field['type']), array_merge(
					array(
						'processor' => $processor,
						'field' => $field
					),
					$field,
					$processor->getRenderedViewProperties($field)
				));
			}

			$fieldErrors = array_key_exists($field['id'], $errors) ? $errors[$field['id']] : array();
			$html .= $this->renderView('form/templates/FieldBox', array_merge(
				array(
					'body' => $fieldRendered,
					'errors' => $fieldErrors,
					'hasErrors' => count($fieldErrors) > 0,
				),
				$field
			));
		}

		return $html;
	}

	/**
	 * Validates the result.
	 *
	 * @param WiseFormsForm $form
	 *
	 * @return array
	 */
	private function validateForm($form) {
		$errors = array();

		// validate nonce:
		if (!wp_verify_nonce($this->getPostParam('wfSendFormNonce'), 'wfSendFormNonceValue')) {
			$errors['form'][] = $form->getMessage('form.nonce.error');
		}

		if (count($errors) === 0) {
			$fields = WiseFormsFieldsUtils::getFlatFieldsArray($form);

			foreach ($fields as $field) {
				$processor = $this->getFieldProcessor($field);

				if ($processor->isValueProvider()) {
					$fieldErrors = $processor->validatePostedValue($form, $field);
					if (count($fieldErrors) > 0) {
						$errors[$field['id']] = $fieldErrors;
					}
				}
			}
		}

		return $errors;
	}

	/**
	 * Sends notifications after form submission.
	 *
	 * @param WiseFormsResult $result
	 * @param WiseFormsForm $form
	 */
	private function sendNotifications($form, $result) {
		$emailRecipient = trim($form->getConfigurationEntry('notifications.email.recipient'));
		if (strlen($emailRecipient) === 0) {
			return;
		}

		$emailRecipientName = $form->getConfigurationEntry('notifications.email.recipient.name');
		$emailSubject = $form->getConfigurationEntry('notifications.email.subject');
		$emailTemplate = $form->getConfigurationEntry('notifications.email.template');

		// render fields:
		$fieldsList = array();
		$resultArray = json_decode($result->getResult(), true);
		$resultArray = is_array($resultArray) ? $resultArray : array();
		foreach ($resultArray as $fieldResult) {
			$processor = $this->getFieldProcessor($fieldResult);
			$fieldName = $fieldResult['name'];
			$fieldValue = $processor->getValueFromFieldResult($fieldResult);

			$fieldsList[] = $fieldName.': '.$fieldValue;
		}

		// render e-mail body:
		$templateParts = array(
			'fields' => implode("\n", $fieldsList),
			'ip' => $result->getIp()
		);
		foreach ($templateParts as $key => $value) {
			$emailTemplate = str_replace('${'.$key.'}', $value, $emailTemplate);
		}

		// include recipient's name:
		if (strlen($emailRecipientName) > 0) {
			$emailRecipient = $emailRecipientName.' <'.$emailRecipient.'>';
		}

		wp_mail($emailRecipient, $emailSubject, $emailTemplate);
	}

	/**
	 * Saves the result.
	 *
	 * @param WiseFormsForm $form
	 *
	 * @return WiseFormsResult
	 */
	private function processForm($form) {
		$fields = WiseFormsFieldsUtils::getFlatFieldsArray($form);

		$result = array();
		foreach ($fields as $field) {
			$processor = $this->getFieldProcessor($field);

			if ($processor->isValueProvider()) {
				$value = $processor->getPostedValue($field);

				$result[] = array(
					'id' => $field['id'],
					'name' => $field['label'],
					'type' => $field['type'],
					'value' => $value
				);
			}
		}

		// store the result
		WiseFormsContainer::load('models/WiseFormsResult');
		$resultObject = new WiseFormsResult();
		$resultObject->setCreated(time());
		$resultObject->setIp($_SERVER['REMOTE_ADDR']);
		$resultObject->setResult(json_encode($result));
		$resultObject->setFormId($form->getId());
		$resultObject->setFormName($form->getName());
		$this->resultsDao->save($resultObject);

		return $resultObject;
	}

	/**
	 * @param array $field Field configuration
	 * @return WiseFormsFieldProcessor
	 */
	private function getFieldProcessor($field) {
		$processorClassName = 'WiseForms'.ucfirst($field['type']).'Processor';

		return WiseFormsContainer::get('fields/processing/'.$processorClassName);
	}
}