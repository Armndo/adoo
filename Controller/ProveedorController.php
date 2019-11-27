<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Proveedor.php");
	include_once("../Model/Direccion.php");
	
	session_start();
	$usuario = null;
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];

	if(empty($_POST))
		header("Location: /proj");

	$controller = new ProveedorController($_POST);

	try {
		$controller->{$_POST["action"]}();
		if($_POST["action"] == "update") {
			if($usuario->getRol() == "Administrador")
				header("Location: /proj/Proveedor/view.php?id=" . $_POST["id"]);
			else
				header("Location: /proj/Proveedor/view.php");
		} else
			header("Location: /proj/Proveedor");
	} catch(Error $e) {
		echo "Error, método no reconocido. <a href='/proj'>Volver</a>";
	}

	class ProveedorController {

		private $request;

		public function __construct($request) {
			$this->request = $request;
		}

		public function store() {
			$usuario = new Usuario();
			$usuario->charge($this->request["email"], $this->request["password"], "Proveedor");
			$usuario->commit();
			$proveedor = new Proveedor();
			$proveedor->charge($this->request["razon"], $this->request["giro"], $usuario->getId());
			$proveedor->commit();
			$direccion = new Direccion();
			$direccion->charge($this->request["calle"], $this->request["numext"], $this->request["numint"], $this->request["estado"], $this->request["municipio"], $this->request["colonia"], $this->request["cp"], null, $proveedor->getId());
			$direccion->commit();
			if($proveedor->getId() == 0) {
				$usuario->destroy();
				$direccion->destroy();
			}
		}

		public function update() {
			$proveedor = new Proveedor();
			$proveedor->find($this->request["id"]);
			$proveedor->usuario()->update($this->request["password"]);
			$proveedor->update($this->request["razon"], $this->request["giro"]);
			$proveedor->direccion()->update($this->request["calle"], $this->request["numext"], $this->request["numint"], $this->request["estado"], $this->request["municipio"], $this->request["colonia"], $this->request["cp"]);
		}

		public function destroy() {
			$proveedor = new Proveedor();
			$proveedor->find($this->request["id"]);
			$proveedor->usuario()->destroy();
		}

	}

?>