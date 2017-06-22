<?php

/**
 * WiseForms utility class for fields.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsFieldsUtils {

	/**
	 * Returns fields as a flat array.
	 *
	 * @param WiseFormsForm $form
	 * @return array
	 */
	public static function getFlatFieldsArray($form) {
		return $form === null ? array() : self::collectFlatFields(json_decode($form->getFields(), true));
	}

	/**
	 * @param array $fields
	 * @return array
	 */
	private static function collectFlatFields($fields) {
		if (!is_array($fields)) {
			return array();
		}

		$out = array();
		foreach ($fields as $field) {
			if (!is_array($field)) {
				continue;
			}

			if (array_key_exists('children', $field)) {
				foreach ($field['children'] as $childrenFields) {
					$out = array_merge($out, self::collectFlatFields($childrenFields));
				}
			} else {
				$out[] = $field;
			}
		}

		return $out;
	}

}