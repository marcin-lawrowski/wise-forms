<?php

/**
 * WiseForms Form DAO class.
 *
 * @author Kainex <contact@kaine.pl>
 */
class WiseFormsFormDAO {

	/**
	 * @var WiseFormsInstaller
	 */
	private $installer;

	/**
	 * @var integer
	 */
	private $limit;

	/**
	 * WiseFormsFormDAO constructor.
	 */
	public function __construct() {
		WiseFormsContainer::load('models/WiseFormsForm');

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
	 * @param WiseFormsForm $object
	 * @return WiseFormsForm
	 * @throws Exception
	 */
	public function save($object) {
		global $wpdb;

		// low-level validation:
		if ($object->getName() === null) {
			throw new Exception('Form name cannot be null');
		}

		// prepare data:
		$columns = array(
			'name' => $object->getName(),
			'fields' => $object->getFields(),
			'messages' => $object->getMessages(),
			'configuration' => $object->getConfiguration(),
			'created' => $object->getCreated() !== null ? $object->getCreated() : time(),
		);

		// update or insert:
		if ($object->getId() !== null) {
			$wpdb->update($this->installer->getFormsTable(), $columns, array('id' => $object->getId()), '%s', '%d');
		} else {
			$wpdb->insert($this->installer->getFormsTable(), $columns);
			$object->setId($wpdb->insert_id);
		}

		return $object;
	}

	/**
	 * @param WiseFormsForm $object
	 * @return WiseFormsForm
	 * @throws Exception
	 */
	public function cloneObject($object) {
		$clone = new WiseFormsForm();
		$clone->setConfiguration($object->getConfiguration());
		$clone->setMessages($object->getMessages());
		$clone->setCreated(time());
		$clone->setFields($object->getFields());
		$clone->setName('Clone of '.$object->getName());

		return $this->save($clone);
	}

	/**
	 * Returns form by ID.
	 *
	 * @param integer $id
	 *
	 * @return WiseFormsForm
	 */
	public function getById($id) {
		global $wpdb;

		$sql = sprintf("SELECT * FROM %s WHERE id = %d LIMIT 1;", $this->installer->getFormsTable(), $id);
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

		$result = $wpdb->delete($this->installer->getFormsTable(), array('id' => $id), array('%d'));

		return $result !== false ? true : false;
	}

	/**
	 * Returns all for given page.
	 *
	 * @param integer $pageNumber Pagination page number
	 *
	 * @return WiseFormsForm[]
	 */
	public function getAll($pageNumber) {
		global $wpdb;

		$offset = ($pageNumber - 1) * $this->limit;
		$sql = sprintf("SELECT * FROM %s ORDER BY id ASC LIMIT %d OFFSET %d;", $this->installer->getFormsTable(), $this->limit, $offset);
		$rows = $wpdb->get_results($sql);

		return $this->populateMultiData($rows);
	}

	/**
	 * Returns all.
	 *
	 * @return WiseFormsForm[]
	 */
	public function getAllNoLimit() {
		global $wpdb;

		$sql = sprintf("SELECT * FROM %s ORDER BY name ASC;", $this->installer->getFormsTable());
		$rows = $wpdb->get_results($sql);

		return $this->populateMultiData($rows);
	}

	/**
	 * @return integer
	 */
	public function getAllCount() {
		global $wpdb;

		$sql = sprintf("SELECT count(id) AS quantity FROM %s;", $this->installer->getFormsTable());
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
	 * @return WiseFormsForm[]
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
	 * @return WiseFormsForm
	 */
	private function populateData($rawData) {
		$object = new WiseFormsForm();
		$object->setId($rawData->id);
		$object->setName($rawData->name);
		$object->setFields($rawData->fields);
		$object->setMessages($rawData->messages);
		$object->setConfiguration($rawData->configuration);
		$object->setCreated($rawData->created);

		return $object;
	}
}