<?php

/**
 * WiseForms Form model.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsForm {
	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $fields;

	/**
	 * @var string
	 */
	private $messages;

	/**
	 * @var string
	 */
	private $configuration;

	/**
	 * @var integer
	 */
	private $created;

	/**
	 * @var array
	 */
	public static $defaultMessages = array(
		// form messages:
		'form.submitted' => 'You have successfully submitted the form. Thank you.',
		'form.submission.error' => 'Please correct the highlighted errors and try again.',
		'form.nonce.error' => 'Please send the form again. It is no longer valid.',

		// validation errors:
		'validation.error.required' => 'Please fill required field.',
		'validation.error.captcha' => 'Invalid calculation result.',
		'validation.error.textinput.email.invalid' => 'E-mail is invalid.',
		'validation.error.textinput.number.invalid' => 'The number is invalid.',
		'validation.error.textinput.dateyyyymmdd.invalid' => 'The date is invalid. Allowed date format: YYYY-MM-DD',
		'validation.error.textinput.datemmddyyyy.invalid' => 'The date is invalid. Allowed date format: MM/DD/YYYY',
	);

	/**
	 * @var array
	 */
	public static $defaultConfiguration = array(
		'appearance.header' => '1',

		'notifications.email.recipient' => '',
		'notifications.email.recipient.name' => 'WordPress Administrator',
		'notifications.email.subject' => 'Form Submission',
		'notifications.email.template' => "Hello,\n\nA new submission of the form has been registered:\n\n\${fields}\n\n--\n\${ip}",
	);

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getFields()
	{
		return $this->fields;
	}

	/**
	 * @param string $fields
	 */
	public function setFields($fields)
	{
		$this->fields = $fields;
	}

	/**
	 * @return int
	 */
	public function getCreated()
	{
		return $this->created;
	}

	/**
	 * @param int $created
	 */
	public function setCreated($created)
	{
		$this->created = $created;
	}

	/**
	 * @return string
	 */
	public function getMessages()
	{
		return $this->messages;
	}

	/**
	 * @param string $messages
	 */
	public function setMessages($messages)
	{
		$this->messages = $messages;
	}

	/**
	 * @return string
	 */
	public function getConfiguration()
	{
		return $this->configuration;
	}

	/**
	 * @param string $configuration
	 */
	public function setConfiguration($configuration)
	{
		$this->configuration = $configuration;
	}

	public function getMessage($id) {
		$currentMessages = json_decode($this->getMessages(), true);
		if (!is_array($currentMessages)) {
			$currentMessages = array();
		}

		if (array_key_exists($id, $currentMessages)) {
			return $currentMessages[$id];
		}

		if (array_key_exists($id, self::$defaultMessages)) {
			return self::$defaultMessages[$id];
		}

		return '';
	}

	public function getConfigurationEntry($id) {
		$currentEntries = json_decode($this->getConfiguration(), true);
		if (!is_array($currentEntries)) {
			$currentEntries = array();
		}

		if (array_key_exists($id, $currentEntries)) {
			return $currentEntries[$id];
		}

		if (array_key_exists($id, self::$defaultConfiguration)) {
			return self::$defaultConfiguration[$id];
		}

		return '';
	}

}