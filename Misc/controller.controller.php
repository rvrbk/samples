<?php

class controller {
	static public function dbi() {
		global $dbi;

		return $dbi;
	}

	static public function get_by_id($model, $id, $cells = null) {
		$query = "SELECT " . (isset($cells) ? implode(",", $cells) : "*") . " FROM " . $model . "
			WHERE id = " . $id;

		self::dbi()->query($query);

		$data = self::dbi()->getResult();

		if(count($data) > 0) {
			return $data[0];
		}

		return false;
	}

	static public function get_one_by_key($model, $key, $value, $cells = null) {
		$query = "SELECT " . (isset($cells) ? implode(",", $cells) : "*") . " FROM " . $model . "
			WHERE " . $key . " = '" . $value . "'";

		self::dbi()->query($query);

		$data = self::dbi()->getResult();

		if(count($data) > 0) {
			return $data[0];
		}

		return false;
	}

	static public function get_one_by_query($query) {
		self::dbi()->query($query);

		$data = self::dbi()->getResult();

		if(count($data) > 0) {
			return $data[0];
		}

		return false;
	}

	static public function cut_string($string, $maxlength, $suffix) {
		if(strlen($string) > $maxlength) {
			return substr($string, 0, $maxlength) . $suffix;
		}

		return $string;
	}
}

?>