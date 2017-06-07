<?php

/**
 * WiseForms result model.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsResult {

	/**
	 * @var integer
	 */
	private $id;

	/**
	 * @var integer
	 */
	private $formId;

	/**
	 * @var string
	 */
	private $formName;

	/**
	 * @var integer
	 */
	private $created;

	/**
	 * @var string
	 */
	private $result;

	/**
	 * @var string
	 */
	private $ip;

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
	 * @return int
	 */
	public function getFormId()
	{
		return $this->formId;
	}

	/**
	 * @param int $formId
	 */
	public function setFormId($formId)
	{
		$this->formId = $formId;
	}

	/**
	 * @return string
	 */
	public function getFormName()
	{
		return $this->formName;
	}

	/**
	 * @param string $formName
	 */
	public function setFormName($formName)
	{
		$this->formName = $formName;
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
	public function getResult()
	{
		return $this->result;
	}

	/**
	 * @param string $result
	 */
	public function setResult($result)
	{
		$this->result = $result;
	}

	/**
	 * @return string
	 */
	public function getIp()
	{
		return $this->ip;
	}

	/**
	 * @param string $ip
	 */
	public function setIp($ip)
	{
		$this->ip = $ip;
	}

}