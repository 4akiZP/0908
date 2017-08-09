<?php

class Route{

	private $routes;

	function __construct(){
			$this->routes = include(ROOT.'/config/routes.php');
	}

	private function getURI(){
		if ($_SERVER['REQUEST_URI']){
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	private function generateHash($login,$password) {
			if (defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
					$salt = substr(md5($login), 0, 22);
					return crypt($password, $salt);
			}
	}

	public function start(){

		$uri = $this->getURI();
		foreach ($this->routes as $uriPattern => $path) {
			if (preg_match("~$uriPattern~", $uri)){
				$uriSegments = explode('/', $path);
				$modelName = ucfirst($uriSegments[0]).'Model';
				$controllerName = ucfirst(array_shift($uriSegments)).'Controller'; // получаем имя контроллера + префиксы
				$actionName = 'action'.ucfirst(array_shift($uriSegments)); // получаем имя экшена + префиксы
				$modelFile = ROOT."/models/".$controllerName.'.php';
				$controllerFile = ROOT."/controllers/".$controllerName.'.php';

				if(file_exists($controllerFile)) //файл с классом контроллера
				{
					include_once($controllerFile);
				}
					// создаем контроллер
					$controller = new $controllerName;
					$action = $actionName;

					if(method_exists($controller, $action))
					{
						// вызываем действие контроллера
						$controller->$action();
					}
			}
		}
	}

}
