<?php
	include_once("../Model/Mensaje.php");
	// include_once("../Model/Audiencia.php");

	$controller = new MensajeController($_POST);
	$controller->{$_POST["action"]}();

	class MensajeController {

		private $request;

		public function __construct($request) {
			$this->request = $request;
		}

		public function store() {
			$mensaje = new Mensaje();
			$mensaje->charge($this->request["user"], $this->request["mensaje"], $this->request["audiencia_id"]);
			$mensaje->commit();
			echo "Mensaje almacenado";
		}

		public function read() {
			foreach (Mensaje::get($this->request["audiencia_id"]) as $mensaje) {
				echo "<p><b>" . $mensaje->getUser() . " (" . date("d/m/Y h:i:s", strtotime($mensaje->getFecha())) . ")</b>: " . $mensaje->getMensaje() . "</p>";
			}
		}

	}

?>