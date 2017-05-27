<?php

/**
 * WiseForms root shortcode.
 *
 * @author Kainex <contact@kaine.pl>
 */
abstract class WiseFormsShortcode {
	protected function getCurrentApplicationPath() {
		return strtok($_SERVER["REQUEST_URI"], '?');
	}

	/**
	 * Returns given GET parameter.
	 *
	 * @param string $parameter
	 *
	 * @return mixed
	 */
	public function getParam($parameter) {
		if (array_key_exists($parameter, $_GET)) {
			return stripslashes_deep($_GET[$parameter]);
		}

		return null;
	}

	/**
	 * Returns given POST parameter.
	 *
	 * @param string $parameter
	 *
	 * @return mixed
	 */
	public function getPostParam($parameter) {
		if (array_key_exists($parameter, $_POST)) {
			return stripslashes_deep($_POST[$parameter]);
		}

		return null;
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

	protected function setSessionParameter($parameter, $value) {
		$_SESSION[$parameter] = $value;
	}

	protected function cleanSessionParameter($parameter) {
		unset($_SESSION[$parameter]);
	}

	protected function getSessionParameter($parameter, $encode = true) {
		if (array_key_exists($parameter, $_SESSION)) {
			if ($encode) {
				return htmlentities($_SESSION[$parameter], ENT_COMPAT, 'UTF-8');
			} else {
				return $_SESSION[$parameter];
			}
		}

		return null;
	}

	protected function redirect($url) {
		if (!headers_sent()) {
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: $url");
			die();
		} else {
			echo "<script>window.location = '$url';</script>";
			die();
		}
	}

	/**
	 * Returns formatted price.
	 *
	 * @param integer $pennyPrice
	 *
	 * @return string
	 */
	protected function formatPrice($pennyPrice) {
		return number_format($pennyPrice / 100, 2).' USD';
	}

	/**
	 * Renders and returns given view.
	 *
	 * @param string $name View's name
	 * @param array $data Data to render
	 *
	 * @return null
	 * @throws \Exception
	 */
	protected function renderView($name, $data) {
		$path = realpath(dirname(__FILE__)).'/templates/'.$name.'.php';
		if (!file_exists($path)) {
			throw new \Exception("View $name does not exist.");
		}

		ob_start();
		extract($data);
		include($path);
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}