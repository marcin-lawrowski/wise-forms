<?php

/**
 * WiseForms forms shortcode.
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

	public function __construct() {
		WiseFormsContainer::load('fields/WiseFormsFieldsUtils');
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');
		$this->resultsDao = WiseFormsContainer::get('dao/WiseFormsResultDAO');
	}

	public function render($attributes) {
		if (!is_array($attributes) || !array_key_exists('id', $attributes)) {
			return '';
		}

		$form = $this->formsDao->getById(intval($attributes['id']));
		if ($form === null) {
			return '';
		}

		// process form sending:
		if ($this->hasPostParam('wfSendForm')) {
			$this->processForm($form);
		}

		return $this->renderView('form/templates/FormShortcode', array(
			'form' => $form,
			'fieldsRendered' => $this->renderFields(json_decode($form->getFields(), true))
		));
	}

	private function renderFields($fields) {
		if (!is_array($fields)) {
			return '';
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
					$children[] = $this->renderFields($childrenFields);
				}

				$fieldRendered = $this->renderView('form/templates/fields/' . ucfirst($field['type']), array_merge(
					array(
						'childrenRendered' => $children,
					),
					$field
				));
			} else {
				$fieldRendered = $this->renderView('form/templates/fields/' . ucfirst($field['type']), $field);
			}

			$html .= $this->renderView('form/templates/FieldBox', array_merge(
				array(
					'body' => $fieldRendered,
				),
				$field
			));
		}

		return $html;
	}

	/**
	 * Saves the result.
	 *
	 * @param WiseFormsForm $form
	 */
	private function processForm($form) {
		$fields = WiseFormsFieldsUtils::getFlatFieldsArray($form);

		$result = array();
		foreach ($fields as $field) {
			$processorClassName = 'WiseForms'.ucfirst($field['type']).'Processor';

			/** @var WiseFormsFieldProcessor $processor */
			$processor = WiseFormsContainer::get('fields/processing/'.$processorClassName);

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
	}

}