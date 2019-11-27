<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Inconformidad.php");
	include_once("../Model/Documento.php");
	include_once("Archivo.php");
	
	session_start();
	$usuario = null;
	if(isset($_SESSION["usuario"]))
		$usuario = $_SESSION["usuario"];

	if(empty($_POST) || $usuario->getRol() == "Administrador" || $usuario->getRol() == "Proveedor")
		header("Location: /proj");

	$_POST["consumidor_id"] = $usuario->persona()->getId();
	$controller = new InconformidadController($_POST, $_FILES);

	try {
		$controller->{$_POST["action"]}();
		header("Location: /proj/Inconformidad");
	} catch(Error $e) {
		echo "$e<br>Error, método no reconocido. <a href='/proj'>Volver</a>";
	}

	class InconformidadController {

		private $request;
		private $files;

		public function __construct($request, $files) {
			$this->request = $request;
			$this->files = $files;
		}

		public function store() {
			$arr = [];
			foreach ($this->files as $file) {
				$arc = new Archivo();
				foreach ($file as $key => $value) {
					$arc->{$key} = $value;
				}
				array_push($arr, $arc);
			}
			$inconformidad = new Inconformidad();
			$inconformidad->charge($this->request["estado"], $this->request["fecha"], $this->request["tipo"], $this->request["divisa"], $this->request["costo"], $this->request["modo"], $this->request["descripcion"], $this->request["consumidor_id"], $this->request["proveedor_id"]);
			$inconformidad->commit();
			if($inconformidad->getId() != 0) {
				$path = "../Archivos/Inconformidad/" . $inconformidad->getId() . "/";
				if (!file_exists($path) && isset($this->files)) {
				    mkdir($path, 0777, true);
				    chmod("../Archivos", 0777);
				}
				foreach ($arr as $key => $file) {
					$url = $path . $file->name;
					if(is_uploaded_file($file->tmp_name)) {
						if(move_uploaded_file($file->tmp_name, $url)) {
							$documento = new Documento();
							$documento->charge($url, $inconformidad->getId());
							$documento->commit();
							echo $file->name . " guardado en disco.<br>";
						} else
							echo $file->name . " no se guardó en disco.<br>";
					} else
						echo $file->name . " no se pudo subir.<br>";
				}
			}
		}

		public function validate() {
			$inconformidad = new Inconformidad();
			$inconformidad->find($this->request["id"]);
			$inconformidad->update("Aprovada");
		}

		public function reject() {
			$inconformidad = new Inconformidad();
			$inconformidad->find($this->request["id"]);
			$inconformidad->update("Rechazada");
		}

		public function destroy() {
			$inconformidad = new Inconformidad();
			$inconformidad->find($this->request["id"]);
			$inconformidad->destroy();
			$path = "../Archivos/Inconformidad/" . $inconformidad->getId() . "/";
			$this->delete($path);
		}

		private function delete($path) {
			if(is_dir($path)) {
				$files = glob($path . "*", GLOB_MARK);
				foreach ($files as $file) {
					$this->delete($file);
				}
				rmdir($path);
			} elseif(is_file($path)) {
				unlink($path);
			}
		}

	}

?>