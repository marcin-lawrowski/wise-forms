<?php

/**
 * WiseForms field processor.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsTextAreaProcessor extends WiseFormsFieldProcessor {

	/**
	 * Validate field and returns errors if there are any.
	 *
	 * @param WiseFormsForm $form
	 * @param array $field
	 *
	 * @return array Array of errors
	 */
	public function validatePostedValue($form, $field) {
		return $this->validateRequiredStringField($form, $field);
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

		$inputStyles = strlen($field['height']) > 0 ? 'height: '.$field['height'].'px' : '';

		$inputClasses = array('wfTextArea');
		if ($field['width'] == '100%') {
			$inputClasses[] = 'wfWidth100';
		}
		$inputClasses = implode(' ', $inputClasses);

		return array(
			'containerClasses' => $containerClasses,
			'labelClasses' => $labelClasses,
			'labelStyles' => $labelStyles,
			'inputContainerClasses' => $inputContainerClasses,
			'inputStyles' => $inputStyles,
			'inputClasses' => $inputClasses
		);
	}

}