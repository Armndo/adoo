<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Audiencia.php");
	
	session_start();
	$usuario = null;
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];

	if(empty($_POST))
		header("Location: /proj");
	$_POST["conciliador_id"] = $usuario->persona()->getId();
	$controller = new AudienciaController($_POST);

	try {
		$controller->{$_POST["action"]}();
		header("Location: /proj/Audiencia");
	} catch(Error $e) {
		echo "Error, método no reconocido. <a href='/proj'>Volver</a>";
	}

	class AudienciaController {

		private $request;

		public function __construct($request) {
			$this->request = $request;
		}

		public function store() {
			$audiencia = new Audiencia();
			$audiencia->charge($this->request["fecha"], $this->request["hora"], $this->request["inconformidad_id"], $this->request["conciliador_id"]);
			$audiencia->commit();
		}

		public function update() {
			$audiencia = new Audiencia();
			$audiencia->find($this->request["id"]);
			$audiencia->update($this->request["fecha"], $this->request["hora"]);
		}

		public function destroy() {
			$audiencia = new Audiencia();
			$audiencia->find($this->request["id"]);
			$audiencia->destroy();
		}

	}

?>