<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Direccion.php");
	
	session_start();
	$usuario = null;
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];

	if(empty($_POST))
		header("Location: /proj");

	$controller = new ConciliadorController($_POST);

	try {
		$controller->{$_POST["action"]}();
		if($_POST["action"] == "update") {
			if($usuario->getRol() == "Administrador")
				header("Location: /proj/Conciliador/view.php?id=" . $_POST["id"]);
			else
				header("Location: /proj/Conciliador/view.php");
		} else
			header("Location: /proj/Conciliador");
	} catch(Error $e) {
		echo "Error, método no reconocido. <a href='/proj'>Volver</a>";
	}

	class ConciliadorController {

		private $request;

		public function __construct($request) {
			$this->request = $request;
		}

		public function store() {
			$usuario = new Usuario();
			$usuario->charge($this->request["email"], $this->request["password"], "Conciliador");
			$usuario->commit();
			$persona = new Persona();
			$persona->charge($this->request["curp"], $this->request["nombre"], $this->request["appaterno"], $this->request["apmaterno"], $this->request["sexo"], $this->request["fecha"], $usuario->getId());
			$persona->commit();
			$direccion = new Direccion();
			$direccion->charge($this->request["calle"], $this->request["numext"], $this->request["numint"], $this->request["estado"], $this->request["municipio"], $this->request["colonia"], $this->request["cp"], $persona->getId(), null);
			$direccion->commit();
			if($persona->getId() == 0) {
				$usuario->destroy();
				$direccion->destroy();
			}
		}

		public function update() {
			$persona = new Persona();
			$persona->find($this->request["id"]);
			$persona->usuario()->update($this->request["password"]);
			$persona->update($this->request["curp"], $this->request["nombre"], $this->request["appaterno"], $this->request["apmaterno"], $this->request["sexo"], $this->request["fecha"]);
			$persona->direccion()->update($this->request["calle"], $this->request["numext"], $this->request["numint"], $this->request["estado"], $this->request["municipio"], $this->request["colonia"], $this->request["cp"]);
		}

		public function destroy() {
			$persona = new Persona();
			$persona->find($this->request["id"]);
			$persona->usuario()->destroy();
		}

	}

?>