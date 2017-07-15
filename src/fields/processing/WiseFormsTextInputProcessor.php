<?php

/**
 * WiseForms field processor.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsTextInputProcessor extends WiseFormsFieldProcessor {

	/**
	 * Validate field and returns errors if there are any.
	 *
	 * @param WiseFormsForm $form
	 * @param array $field
	 *
	 * @return array Array of errors
	 */
	public function validatePostedValue($form, $field) {
		$requiredValidator = $this->validateRequiredStringField($form, $field);
		if (count($requiredValidator) > 0) {
			return $requiredValidator;
		}

		$errors = array();
		$validator = null;
		if (array_key_exists('validation', $field) && strlen($field['validation']) > 0) {
			$postedValue = $this->getPostedValue($field);
			$validator = $field['validation'];

			switch ($validator) {
				case 'email':
					if (!filter_var($postedValue, FILTER_VALIDATE_EMAIL)) {
						$errors[] = $form->getMessage('validation.error.textinput.email.invalid');
					}
					break;
				case 'number':
					if (!filter_var($postedValue, FILTER_VALIDATE_INT)) {
						$errors[] = $form->getMessage('validation.error.textinput.number.invalid');
					}
					break;
				case 'date-yyyyy-mm-dd':
					if (!$this->validateDate($postedValue, 'Y-m-d')) {
						$errors[] = $form->getMessage('validation.error.textinput.dateyyyymmdd.invalid');
					}
					break;
				case 'date-mm/dd/yyyy':
					if (!$this->validateDate($postedValue, 'm/d/Y') && !$this->validateDate($postedValue, 'n/d/Y') &&
						!$this->validateDate($postedValue, 'n/j/Y') && !$this->validateDate($postedValue, 'm/j/Y')
					) {
						$errors[] = $form->getMessage('validation.error.textinput.datemmddyyyy.invalid');
					}
					break;
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
		if ($field['width'] == '100%') {
			$inputContainerClasses[] = 'wfWidth100';
		}
		$inputContainerClasses = implode(' ', $inputContainerClasses);

		$inputClasses = array('wfFieldInput');
		if ($field['width'] == '100%') {
			$inputClasses[] = 'wfWidth100';
		}
		$inputClasses = implode(' ', $inputClasses);

		return array(
			'containerClasses' => $containerClasses,
			'labelClasses' => $labelClasses,
			'labelStyles' => $labelStyles,
			'inputContainerClasses' => $inputContainerClasses,
			'inputClasses' => $inputClasses
		);
	}

	private function validateDate($date, $format = 'Y-m-d H:i:s') {
		$d = DateTime::createFromFormat($format, $date);

		return $d && $d->format($format) == $date;
	}

}