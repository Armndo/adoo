<?php
	include_once("../Model/Usuario.php");

	if(empty($_POST))
		header("Location: /proj");

	$controller = new SessionController($_POST);

	try {
		$controller->{$_POST["action"]}();
		header("Location: /proj");
	} catch(Error $e) {
		echo "Error, método no reconocido. <a href='/proj'>Volver</a>";
	}

	class SessionController {

		private $request;

		public function __construct($request) {
			$this->request = $request;
			session_start();
		}

		public function login() {
			if(!isset($_SESSION["usuario"])) {
				$id = Usuario::verify($this->request["email"], $this->request["password"]);
				echo "$id";
				if($id != 0) {
					$usuario = new Usuario();
					$usuario->find($id);
					$_SESSION["usuario"] = $usuario;
				}
			}
		}

		public function logout() {
			if(isset($_SESSION["usuario"])) {
				$_SESSION = [];
				session_destroy();
			}
		}

	}

?>