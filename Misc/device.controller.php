<?php

class devicecontroller extends controller {
	static public function get_all($order, $limit = null) {
		$db = new dbi();

		$query = "SELECT device.*, 
			device.id AS device__id,
			device.name AS device__name, 
			device.type AS device__type,
			device.email AS device__email,
			device.password AS device__password,
			device.simid AS device__simid, 
			device.zulu_uid AS device__zulu_uid,
			device.remarks AS device__remarks,
			installers.name AS installers__name, 
			installer_teams.name AS installer_teams__name,
			installer_teams.app_version AS installer_teams__app_version 
			FROM device
			LEFT JOIN installers ON installers.id = device.installer_id
			LEFT JOIN installer_teams ON installer_teams.id = device.team_id
			ORDER BY " . $order . " " . (isset($limit) ? "LIMIT " . $limit : "");

		$db->query($query);

		return $db->getResult();
	}

	static public function handle_unknown_devices() {
		$db = new dbi();

		$query = "SELECT installer_teams.*,
			device.id AS device__id,
			device.unknown AS device__unknown
			FROM installer_teams
			LEFT JOIN device ON installer_teams.id = device.team_id  
			WHERE app_version != ''";

		$db->query($query);

		$data = $db->getResult();

		foreach($data as $key => $value) {
			if(!isset($value["device__id"])) {
				$db->query("INSERT INTO device(installer_id, team_id, unknown, type) VALUES('" . $value["installer_id"] . "', '" . $value["id"] . "', 1, '" . $value["useragent"] . "')");
			}
			else if($value["device__unknown"] > 0) {
				$db->query("UPDATE device SET type = '" . $value["useragent"] . "' WHERE id = " . $value["device__id"]);
			}
		}
	}

	static public function get_device_by_id($id) {
		$db = new dbi();

		$query = "SELECT device.*, 
			device.id AS device__id,
			device.name AS device__name, 
			device.type AS device__type,
			device.email AS device__email,
			device.password AS device__password,
			device.simid AS device__simid,
			device.sim_pin AS device__sim_pin,
			device.sim_puk AS device__sim_puk,
			device.zulu_uid AS device__zulu_uid,
			device.remarks AS device__remarks, 
			installers.id AS installers__id, 
			installer_teams.id AS installer_teams__id,
			installer_teams.app_version AS installer_teams__app_version,
			installer_teams.useragent AS installer_teams__useragent
			FROM device
			LEFT JOIN installers ON installers.id = device.installer_id
			LEFT JOIN installer_teams ON installer_teams.id = device.team_id
			WHERE device.id = " . $id;

		$db->query($query);

		$data = $db->getResult();

		if(count($data) > 0) {
			return $data[0];
		}
	}

	static public function get_last_app_version() {
		$db = new dbi();

		$query = "SELECT app_version FROM installer_teams ORDER BY version_date DESC LIMIT 1";

		$db->query($query);
	
		$data = $db->getResult();

		if(count($data) > 0) {
			return $data[0];
		}
	}

	static public function get_device_types() {
		$db = new dbi();

		$query = "SELECT DISTINCT(type) FROM device ORDER BY type DESC";

		$db->query($query);

		return $db->getResult();
	}

	static public function delete($id) {
		$db = new dbi();

		$query = "DELETE FROM device WHERE id = " . $id;

		$db->query($query);
	}

	static public function save($data, $id = null) {
		$db = new dbi();

		if(isset($id)) {
			$query = "UPDATE device SET remarks = '" . $data["device__remarks"] . "', sim_pin = '" . $data["device__sim_pin"] . "', sim_puk = '" . $data["device__sim_puk"] . "', email = '" . $data["device__email"] . "', zulu_uid = '" . $data["device__zulu_uid"] . "', password = '" . $data["device__password"] . "', name = '" . $data["device__name"] . "', type = '" . $data["device__type"] . "', simid = '" . $data["device__simid"] . "', installer_id = '" . $data["installers__id"] . "', team_id = '" . $data["installer_teams__id"] . "'
				WHERE id = " . $id;
		}
		else {
			$query = "INSERT INTO device(remarks, sim_pin, sim_puk, email, zulu_uid, password, name, type, simid, installer_id, team_id) 
				VALUES('" . $data["device__remarks"] . "', '" . $data["device__sim_pin"] . "', '" . $data["device__sim_puk"] . "', '" . $data["device__email"] . "', '" . $data["device__zulu_uid"] . "', '" . $data["device__password"] . "', '" . $data["device__name"] . "', '" . $data["device__type"] . "', '" . $data["device__simid"] . "', '" . $data["installers__id"] . "', '" . $data["installer_teams__id"] . "')";
		}

		$db->query($query);
	}
}

?>