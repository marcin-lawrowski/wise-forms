<?php

/**
 * WiseForms field processor.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsCheckboxesProcessor extends WiseFormsFieldProcessor {

	/**
	 * @param array $field
	 *
	 * @return array
	 */
	public function getPostedValue($field) {
		$values = parent::getPostedValue($field);
		if (!is_array($values)) {
			return array();
		}

		$out = array();
		if (is_array($field['options'])) {
			foreach ($field['options'] as $key => $option) {
				if (in_array($option['key'], $values)) {
					$out[$option['key']] = $option['value'];
				}
			}
		}

		return $out;
	}

	/**
	 * Validate field and returns errors if there are any.
	 *
	 * @param WiseFormsForm $form
	 * @param array $field
	 *
	 * @return array Array of errors
	 */
	public function validatePostedValue($form, $field) {
		$postedValue = $this->getPostedValue($field);
		if ($field['required'] === true && count($postedValue) === 0) {
			return array($form->getMessage('validation.error.required'));
		}

		return array();
	}

	/**
	 * @param array $fieldResult
	 *
	 * @return string|null
	 */
	public function getValueFromFieldResult($fieldResult) {
		if (array_key_exists('value', $fieldResult)) {
			if (is_array($fieldResult['value'])) {
				return implode(', ', $fieldResult['value']);
			}

			return '';
		}

		return null;
	}

}