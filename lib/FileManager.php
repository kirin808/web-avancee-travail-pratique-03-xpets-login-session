<?php

	namespace XPetsIntl;

	class FileManager {
		static private $extension = ".php";
		static private $modelPath = ROOTPATH . "model/";
		static private $controllerPath = ROOTPATH . "controller/";
		static private $libPath = ROOTPATH . "lib/";

		static private $host = "https://akira.info" . ROOTDIR;

		static function model($page){
			return require_once self::$modelPath . $page. self::$extension;
		}

		static function controller($page){
			return require_once self::$controllerPath . $page. self::$extension;
		}

		static function lib($page){
			return require_once self::$libPath . $page. self::$extension;
		}
		
		static function redirect($url = "xpets") {
			header("Location: " . self::$host . $url);
		}
	}
?>