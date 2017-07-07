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

}