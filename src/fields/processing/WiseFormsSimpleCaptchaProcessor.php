<?php

/**
 * WiseForms field processor.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsSimpleCaptchaProcessor extends WiseFormsFieldProcessor {

	/**
	 * Validate field and returns errors if there are any.
	 *
	 * @param WiseFormsForm $form
	 * @param array $field
	 *
	 * @return array Array of errors
	 */
	public function validatePostedValue($form, $field) {
		$errors =  $this->validateRequiredStringField($form, $field);
		$postedValue = $this->getPostedValue($field);

		if (($field['required'] === true || strlen($postedValue) > 0) && count($errors) == 0) {
			$validResult = base64_decode($this->getPostParam($field['id'] . '_result'));
			$validResult = WiseFormsCrypt::decrypt($validResult);

			if ($validResult != $postedValue) {
				return array($form->getMessage('validation.error.captcha'));
			}
		}

		return $errors;
	}

	/**
	 * Returns an additional set of properties used to render the field in front-end.
	 *
	 * @param array $field
	 *
	 * @return array Array of properties used for rendering
	 */
	public function getRenderedViewProperties($field) {
		$containerClasses = $field['labelLocation'] == 'inline' && strlen($field['labelWidth']) > 0 ? 'wfTable' : '';

		$labelClasses = array('wfFieldLabel', 'wfFieldLabelAlign'.ucfirst($field['labelAlign']));
		if ($field['labelLocation'] == 'inline') {
			$labelClasses[] = 'wfCell';
		}
		$labelClasses = implode(' ', $labelClasses);

		$labelStyles = strlen($field['labelWidth']) > 0 ? 'width: '.$field['labelWidth'].'px' : '';

		$inputContainerClasses = array();
		if ($field['labelLocation'] == 'inline' && strlen($field['label']) > 0) {
			$inputContainerClasses[] = 'wfCell';
		}
		$inputContainerClasses = implode(' ', $inputContainerClasses);

		$inputClasses = array('wfFieldInput');
		$inputClasses = implode(' ', $inputClasses);

		return array(
			'containerClasses' => $containerClasses,
			'labelClasses' => $labelClasses,
			'labelStyles' => $labelStyles,
			'inputContainerClasses' => $inputContainerClasses,
			'inputClasses' => $inputClasses
		);
	}

}