<?php

/**
 * WiseForms field processor.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsButtonSubmitProcessor extends WiseFormsFieldProcessor {

	/**
	 * @return boolean
	 */
	public function isValueProvider() {
		return false;
	}

	/**
	 * Returns an additional set of properties used to render the field in front-end.
	 *
	 * @param array $field
	 *
	 * @return array Array of properties used for rendering
	 */
	public function getRenderedViewProperties($field) {
		$containerClasses = 'wfFieldTextAlign'.ucfirst($field['align']);

		return array(
			'containerClasses' => $containerClasses,
		);
	}

}