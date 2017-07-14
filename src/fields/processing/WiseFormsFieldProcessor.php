<?php

/**
 * WiseForms root field processor.
 *
 * @author Kainex <contact@kaine.pl>
 */
abstract class WiseFormsFieldProcessor {

	/**
	 * @param array $field
	 *
	 * @return mixed|null
	 */
	public function getPostedValue($field) {
		if ($this->hasPostParam($field['id'])) {
			return $this->getPostParam($field['id']);
		}

		return null;
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
		return array();
	}

	/**
	 * Validate required string field and returns errors if there are any.
	 *
	 * @param WiseFormsForm $form
	 * @param array $field
	 *
	 * @return array Array of errors
	 */
	protected function validateRequiredStringField($form, $field) {
		$postedValue = $this->getPostedValue($field);
		if ($field['required'] === true && strlen($postedValue) === 0) {
			return array($form->getMessage('validation.error.required'));
		}

		return array();
	}

	/**
	 * @param array $fieldResult
	 *
	 * @return mixed|null
	 */
	public function getValueFromFieldResult($fieldResult) {
		if (array_key_exists('value', $fieldResult)) {
			return $fieldResult['value'];
		}

		return null;
	}

	/**
	 * @return boolean
	 */
	public function isValueProvider() {
		return true;
	}

	/**
	 * Returns an additional set of properties used to render the field in front-end.
	 *
	 * @param array $field
	 *
	 * @return array Array of properties used for rendering
	 */
	public function getRenderedViewProperties($field) {
		return array();
	}

	/**
	 * Returns given POST parameter.
	 *
	 * @param string $parameter
	 *
	 * @return mixed
	 */
	protected function getPostParam($parameter) {
		if (array_key_exists($parameter, $_POST)) {
			return stripslashes_deep($_POST[$parameter]);
		}

		return null;
	}

	/**
	 * Checks if the given POST parameter exists.
	 *
	 * @param string $paramName
	 *
	 * @return boolean
	 */
	protected function hasPostParam($paramName) {
		return array_key_exists($paramName, $_POST);
	}
}