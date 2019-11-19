<?php
	include_once("../Model/Consumidor.php");
	include_once("../Model/Usuario.php");
	
	session_start();
	$usuario = null;
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];

	if(empty($_POST))
		header("Location: /proj");

	$controller = new ConsumidorController($_POST);

	try {
		$controller->{$_POST["action"]}();
		if($_POST["action"] == "update") {
			if($usuario->getRol() == "Administrador")
				header("Location: /proj/Consumidor/view.php?id=" . $_POST["id"]);
			else
				header("Location: /proj/Consumidor/view.php");
		} else
			header("Location: /proj/Consumidor");
	} catch(Error $e) {
		echo "Error, método no reconocido. <a href='/proj'>Volver</a>";
	}

	class ConsumidorController {

		private $request;

		public function __construct($request) {
			$this->request = $request;
		}

		public function store() {
			$usuario = new Usuario();
			$usuario->charge($this->request["email"], $this->request["password"], "Consumidor");
			$usuario->commit();
			$consumidor = new Consumidor();
			$consumidor->charge($this->request["curp"], $this->request["nombre"], $this->request["appaterno"], $this->request["apmaterno"], $this->request["sexo"], $this->request["fecha"], $this->request["calle"], $this->request["numext"], $this->request["numint"], $this->request["estado"], $this->request["municipio"], $this->request["colonia"], $this->request["cp"], $usuario->getId());
			$consumidor->commit();
			if($consumidor->getId() == 0)
				$usuario->destroy();
		}

		public function update() {
			$consumidor = new Consumidor();
			$consumidor->find($this->request["id"]);
			$consumidor->usuario()->update($this->request["password"]);
			$consumidor->update($this->request["curp"], $this->request["nombre"], $this->request["appaterno"], $this->request["apmaterno"], $this->request["sexo"], $this->request["fecha"], $this->request["calle"], $this->request["numext"], $this->request["numint"], $this->request["estado"], $this->request["municipio"], $this->request["colonia"], $this->request["cp"]);
		}

		public function destroy() {
			$consumidor = new Consumidor();
			$consumidor->find($this->request["id"]);
			$consumidor->usuario()->destroy();
		}

	}

?>