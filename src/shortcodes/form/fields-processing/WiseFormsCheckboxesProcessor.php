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
	 * @return mixed|null
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

}