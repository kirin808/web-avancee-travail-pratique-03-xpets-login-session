<?php
	namespace XPetsIntl;

	session_start();

	define("NS", __NAMESPACE__ . "\\");
	// Pour les require et include.
	define(__NAMESPACE__ . "\ROOTPATH", __DIR__ . "/");
	// Pour la navigation et les src.
	define(__NAMESPACE__ . "\ROOTDIR", "/582-31B-MA-Programmation-web-avancees/travail-pratique-03/dev-local/");
	// Fingerprinting
	define(__NAMESPACE__ . "\SECRET_SPICE", md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER["REMOTE_ADDR"] . "--éé--"));
	
	require_once __DIR__ . '/lib/FileManager.php';
	require_once __DIR__ . '/vendor/autoload.php';
	
	FileManager::controller("TwigController");
	FileManager::lib("SessionManager");

	//recuperer le chemin (URL) et mettre dans un tableau
	if(substr($_SERVER["REQUEST_URI"], 0, strlen(ROOTDIR)) == ROOTDIR) {
		$slug = substr($_SERVER["REQUEST_URI"], strlen(ROOTDIR));
	}

	$url = (explode('/', $slug)[0] != "") ?
		explode('/', $slug) :
		"/";

	if($url == "/"){
		FileManager::redirect("xpets");
	} else{
		if(!(strpos($slug, "login") === 0)) {
			$_SESSION["referer"] = $slug;
		}

		$requestUrl = $url[0];
		
		//recuperer le controleur
		$controllerPath = __DIR__ . "/controller/" . ucfirst($requestUrl) . "Controller.php";
		
		if(file_exists($controllerPath)) {
			
			// require_once $controllerPath;
			FileManager::controller(ucfirst($requestUrl) . "Controller");
		
			$controllerName = NS . ucfirst($requestUrl).'Controller';
			$controller = new $controllerName;

			if(isset($url[1])) {
				$id = null;

				if(is_numeric($url[1]) && isset($url[2])) {
					echo $controller->index($url[1], $url[2]);
				} else {
					$method = $url[1];

					if($method === "formulaire" && !SessionManager::canEdit()) {
						FileManager::redirect("xpets");
					}

					if(isset($url[2]) && is_numeric($url[2])) {
						$id = $url[2];
					}
					
					if(method_exists($controller, $method)) {
						echo $controller->$method($id);		
					} else {
						FileManager::redirect("xpets");	
					}
				}				
			} else {
				echo $controller->index();
			}			
		} else {
			FileManager::redirect("xpets");
		}

	}

?>