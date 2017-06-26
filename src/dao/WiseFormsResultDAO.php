<?php

/**
 * WiseForms Result DAO class.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsResultDAO {

	/**
	 * @var WiseFormsInstaller
	 */
	private $installer;

	/**
	 * @var integer
	 */
	private $limit;

	/**
	 * WiseFormsResultDAO constructor.
	 */
	public function __construct() {
		WiseFormsContainer::load('models/WiseFormsResult');

		$this->limit = 15;
		$this->installer = WiseFormsContainer::get('WiseFormsInstaller');
	}

	/**
	 * @return int
	 */
	public function getLimit() {
		return $this->limit;
	}

	/**
	 * @param WiseFormsResult $object
	 * @return WiseFormsResult
	 * @throws Exception
	 */
	public function save($object) {
		global $wpdb;

		// low-level validation:
		if ($object->getFormId() === null) {
			throw new Exception('Form ID cannot be null');
		}
		if ($object->getFormName() === null) {
			throw new Exception('Form name cannot be null');
		}

		// prepare data:
		$columns = array(
			'form_name' => $object->getFormName(),
			'form_id' => $object->getFormId(),
			'ip' => $object->getIp(),
			'result' => $object->getResult(),
			'created' => $object->getCreated() !== null ? $object->getCreated() : time(),
		);

		// update or insert:
		if ($object->getId() !== null) {
			$wpdb->update($this->installer->getResultsTable(), $columns, array('id' => $object->getId()), '%s', '%d');
		} else {
			$wpdb->insert($this->installer->getResultsTable(), $columns);
			$object->setId($wpdb->insert_id);
		}

		return $object;
	}

	/**
	 * Returns result by ID.
	 *
	 * @param integer $id
	 *
	 * @return WiseFormsResult
	 */
	public function getById($id) {
		global $wpdb;

		$sql = sprintf("SELECT * FROM %s WHERE id = %d LIMIT 1;", $this->installer->getResultsTable(), $id);
		$rows = $wpdb->get_results($sql);
		if (is_array($rows) && count($rows) > 0) {
			return $this->populateData($rows[0]);
		}

		return null;
	}

	/**
	 * Deletes form by ID.
	 *
	 * @param integer $id
	 *
	 * @return boolean
	 */
	public function deleteById($id) {
		global $wpdb;

		$result = $wpdb->delete($this->installer->getResultsTable(), array('id' => $id), array('%d'));

		return $result !== false ? true : false;
	}

	/**
	 * Returns all for given page.
	 *
	 * @param integer $formId
	 * @param string $keyword
	 * @param integer $pageNumber Pagination page number
	 *
	 * @return WiseFormsResult[]
	 */
	public function getAll($formId, $keyword, $pageNumber) {
		global $wpdb;

		$searchCondition = $this->getSQLCondition($formId, $keyword);

		$offset = ($pageNumber - 1) * $this->limit;
		$sql = sprintf("SELECT * FROM %s %s ORDER BY id DESC LIMIT %d OFFSET %d;", $this->installer->getResultsTable(), $searchCondition, $this->limit, $offset);
		$rows = $wpdb->get_results($sql);

		return $this->populateMultiData($rows);
	}

	/**
	 *
	 * @param integer $formId
	 * @param string $keyword
	 * @return integer
	 */
	public function getAllCount($formId, $keyword = '') {
		global $wpdb;

		$searchCondition = $this->getSQLCondition($formId, $keyword);

		$sql = sprintf("SELECT count(id) AS quantity FROM %s %s;", $this->installer->getResultsTable(), $searchCondition);
		$results = $wpdb->get_results($sql);

		if (is_array($results) && count($results) > 0) {
			$result = $results[0];
			return $result->quantity;
		}

		return 0;
	}

	/**
	 * @param stdClass[] $rows
	 *
	 * @return WiseFormsResult[]
	 */
	private function populateMultiData($rows) {
		if (!is_array($rows)) {
			return array();
		}

		$objects = array();
		foreach ($rows as $row) {
			$objects[] = $this->populateData($row);
		}

		return $objects;
	}

	/**
	 * @param stdClass $rawData
	 *
	 * @return WiseFormsResult
	 */
	private function populateData($rawData) {
		$object = new WiseFormsResult();
		$object->setId($rawData->id);
		$object->setFormName($rawData->form_name);
		$object->setFormId($rawData->form_id);
		$object->setIp($rawData->ip);
		$object->setResult($rawData->result);
		$object->setCreated($rawData->created);

		return $object;
	}

	private function getSQLCondition($formId, $keyword) {
		$keyword = trim($keyword);
		$formId = intval($formId);
		if (strlen($keyword) === 0 && $formId === 0) {
			return '';
		}

		$keyword = addslashes(strtolower($keyword));
		$fields = array('form_name', 'result', 'ip', 'id');
		$conditions = array();
		foreach ($fields as $field) {
			$conditions[] = "LOWER(".$field.") LIKE '%".$keyword."%'";
		}

		$andConditions = array();
		if (count($conditions) > 0) {
			$andConditions[] = '('.implode(' OR ', $conditions).')';
		}

		if ($formId > 0) {
			$andConditions[] = 'form_id = '.intval($formId);
		}

		if (count($andConditions) > 0) {
			return ' WHERE '.implode(' AND ', $andConditions).' ';
		}

		return '';
	}
}