<?php

	namespace XPetsIntl;

	class SessionManager {
		static private $editors = [2];

		static public function loggedIn() {
			if(isset($_SESSION["userId"]) && $_SESSION["fingerprint"] === SECRET_SPICE) {
				return true;
			}

			return false;
		}

		static public function canEdit() {
			return in_array($_SESSION["roleId"], self::$editors);
		}
	}

?>