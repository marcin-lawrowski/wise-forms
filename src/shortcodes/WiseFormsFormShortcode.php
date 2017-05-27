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

	public function __construct() {
		$this->formsDao = WiseFormsContainer::get('dao/WiseFormsFormDAO');
	}

	public function render($attributes) {
		if (!is_array($attributes) || !array_key_exists('id', $attributes)) {
			return '';
		}

		$form = $this->formsDao->getById(intval($attributes['id']));
		if ($form === null) {
			return '';
		}

		return $this->renderView('FormShortcode', array(
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

				$fieldRendered = $this->renderView('form/fields/' . ucfirst($field['type']), array(
					'field' => $field,
					'children' => $children
				));
			} else {
				$fieldRendered = $this->renderView('form/fields/' . ucfirst($field['type']), $field);
			}

			$html .= $this->renderView('form/FieldBox', array(
				'body' => $fieldRendered,
				'field' => $field
			));
		}

		return $html;
	}

}