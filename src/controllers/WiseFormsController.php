<?php

/**
 * WiseForms root controller.
 *
 * @author Kainex <contact@kaine.pl>
 */
abstract class WiseFormsController {

	const SESSION_KEY_MESSAGE_INFO = 'wise-forms-admin-message-info';
	const SESSION_KEY_MESSAGE_ERROR = 'wise-forms-admin-message-error';

	protected $controllerId = 'undefined';

	/**
	 * @return null
	 */
	public abstract function run();

	/**
	 * Executes actions, displays messages and runs the controller.
	 */
	public function execute() {
		$this->doActions();
		$this->showMessages();
		$this->run();
	}

	/**
	 * Returns URL for pagination.
	 *
	 * @param integer $pageNumber
	 * @param array $params
	 *
	 * @return string
	 */
	protected function getIndexPageUrl($pageNumber = 1, $params = array()) {
		$data = array();
		if ($pageNumber > 1) {
			$data['pageNum'] = $pageNumber;
		}
		foreach ($params as $key => $param) {
			if (strlen($param) > 0) {
				$data[$key] = $param;
			}
		}

		return $this->constructUrl($data);
	}

	/**
	 * Returns given GET parameter or the default value.
	 *
	 * @param string $paramName
	 * @param mixed $defaultValue
	 *
	 * @return mixed
	 */
	protected function getParam($paramName, $defaultValue = null) {
		return array_key_exists($paramName, $_GET) ? stripslashes_deep($_GET[$paramName]) : $defaultValue;
	}

	/**
	 * Returns given POST parameter or the default value.
	 *
	 * @param string $paramName
	 * @param mixed $defaultValue
	 *
	 * @return mixed
	 */
	protected function getPostParam($paramName, $defaultValue = null) {
		$paramName = str_replace('.', '_', $paramName);

		return array_key_exists($paramName, $_POST) ? stripslashes_deep($_POST[$paramName]) : $defaultValue;
	}

	/**
	 * Checks if the given GET parameter exists.
	 *
	 * @param string $paramName
	 *
	 * @return boolean
	 */
	protected function hasParam($paramName) {
		return array_key_exists($paramName, $_GET);
	}

	/**
	 * Checks if the given POST parameter exists.
	 *
	 * @param string $paramName
	 *
	 * @return boolean
	 */
	protected function hasPostParam($paramName) {
		return array_key_exists($paramName, $_POST);
	}

	/**
	 * Renders given view.
	 *
	 * @param string $name View's name
	 * @param array $data Data to render
	 *
	 * @throws Exception
	 *
	 * @return null
	 */
	protected function showView($name, $data) {
		$path = realpath(dirname(__FILE__).'/../views').'/'.$name.'.php';
		if (!file_exists($path)) {
			throw new Exception("View $name does not exist.");
		}
		extract($data);
		include($path);
	}

	/**
	 * Performs client-side redirection.
	 *
	 * @param string $url
	 *
	 * @return null
	 */
	protected function redirect($url) {
		echo '<script>window.location = "'.$url.'";</script>';
		die();
	}

	protected function doActions() {
		$action = $this->getParam('action');

		$action = str_replace(' ', '', lcfirst(ucwords(str_replace('-', ' ', $action))));
		if (strlen($action) > 0) {
			$method = $action.'Action';
			if (method_exists($this, $method)) {
				$this->$method();
			}
		}
	}

	protected function verfiyNonce($name) {
		return wp_verify_nonce($_REQUEST['nonce'], $name) !== false;
	}

	/**
	 * Returns current page numner according to the "pageNum" GET parameter.
	 *
	 * @return integer
	 */
	protected function getCurrentPageNum() {
		$currentPage = intval($this->getParam('pageNum'));

		return ($currentPage <= 0 ? 1 : $currentPage);
	}

	/**
	 * Returns formatted price.
	 *
	 * @param integer $pennyPrice
	 *
	 * @return string
	 */
	protected function formatPrice($pennyPrice, $withCurrencySign = true) {
		return number_format($pennyPrice / 100, 2).($withCurrencySign === true ? ' USD' : '');
	}

	/**
	 * Returns safe text.
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	protected function safeText($text) {
		return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}

	/**
	 * Returns URL for current controller with given parameters.
	 *
	 * @param array $params
	 *
	 * @return string
	 */
	protected function constructUrl($params) {
		$params['page'] = $this->controllerId;

		return admin_url('admin.php?'.http_build_query($params));
	}

	/**
	 * Shows the message.
	 *
	 * @param string $message
	 *
	 * @return null
	 */
	protected function addMessage($message) {
		$_SESSION[self::SESSION_KEY_MESSAGE_INFO] = $message;
	}

	/**
	 * Shows error message.
	 *
	 * @param string $message
	 *
	 * @return null
	 */
	protected function addErrorMessage($message) {
		$_SESSION[self::SESSION_KEY_MESSAGE_ERROR] = $message;
	}

	/**
	 * Shows all messages stored in the session.
	 *
	 * @return null
	 */
	public function showMessages() {
		if (isset($_SESSION[self::SESSION_KEY_MESSAGE_INFO])) {
			echo sprintf('<div class="updated settings-error notice is-dismissible">
					<p><strong>%s</strong></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
				</div>',
				$_SESSION[self::SESSION_KEY_MESSAGE_INFO]
			);

			unset($_SESSION[self::SESSION_KEY_MESSAGE_INFO]);
		}

		if (isset($_SESSION[self::SESSION_KEY_MESSAGE_ERROR])) {
			echo sprintf('<div class="error settings-error notice is-dismissible">
					<p><strong>%s</strong></p>
					<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
				</div>',
				$_SESSION[self::SESSION_KEY_MESSAGE_ERROR]
			);
			unset($_SESSION[self::SESSION_KEY_MESSAGE_ERROR]);
		}
	}

	protected function validateTimestamp($text, $format = 'Y-m-d H:i:s') {
		$d = \DateTime::createFromFormat($format, $text);

		return $d && $d->format($format) == $text;
	}
}