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
	 * @var integer
	 */
	private $created;

	/**
	 * @var array
	 */
	public static $defaultMessages = array(
		'form.submitted' => 'You have successfully submitted the form. Thank you.'
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

}