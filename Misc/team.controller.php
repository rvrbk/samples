<?php

class teamcontroller extends controller {
	static public function get_by_account_id($account_id, $order, $limit = null) {
		self::dbi()->query("SELECT installer_teams.* FROM installer_teams
			LEFT JOIN useraccounts ON useraccounts.account_id = " . $account_id . "
			WHERE installer_teams.installer_id = useraccounts.installer_id
			ORDER BY " . $order . "
			" . (isset($limit) ? " LIMIT " . $limit : ""));

		return self::dbi()->getResult();
	}

	static public function delete_by_id($id) {
		self::dbi()->query("DELETE FROM installer_teams WHERE id = " . $id);
	}

	static public function save($data, $team_id = null) {
		if(isset($team_id)) {
			self::dbi()->query("UPDATE installer_teams SET color = '" . $data["color"] . "', name = '" . $data["name"] . "', password = '" . $data["password"] . "', hash = '" . hash("sha512", $data["password"]) . "' WHERE id = " . $team_id);
		}
		else {
			$account = usercontroller::get_user_by_id($_SESSION["account_id"]);

			self::dbi()->query("INSERT INTO installer_teams(color, hash, name, password, installer_id) VALUES('" . $data["color"] . "', '" . hash("sha512", $data["password"]) . "', '" . $data["name"] . "', '" . $data["password"] . "', '" . $account["installer_id"] . "')");
		}
	}

	static public function get_by_id($team_id) {
		self::dbi()->query("SELECT * FROM installer_teams WHERE id = " . $team_id);

		$data = self::dbi()->getResult();

		if(count($data) > 0) {
			return $data[0];
		}

		return false;
	}

	static public function login($name, $password) {
		self::dbi()->query("SELECT * FROM installer_teams WHERE name = '" . $name . "'");

		foreach(self::dbi()->getResult() as $key => $value) {
			if($value["hash"] != "") {
				self::dbi()->query("SELECT * FROM installer_teams WHERE name = '" . $name . "' AND hash = '" . hash("sha512", $password) . "'");
			}
			else {
				self::dbi()->query("SELECT * FROM installer_teams WHERE name = '" . $name . "' AND password = '" . $password . "'");
			}

			$data = self::dbi()->getResult();

			if(count($data) > 0) {
				return $data[0];
			}
		}

		return false;
	}
}

?>