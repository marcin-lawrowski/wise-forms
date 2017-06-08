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
	 * @return boolean
	 */
	public function isValueProvider() {
		return true;
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