<?php
	include_once("Connection.php");

	class Mensaje {
	 
	 	private $id;
		private $user;
		private $mensaje;
		private $fecha;
		private $audiencia_id;

	    public function charge($user, $mensaje, $audiencia_id) {
		    $this->user = $user;
		    $this->mensaje = $mensaje;
		    $this->audiencia_id = $audiencia_id;
	    }

	    public function put($id, $user, $mensaje, $fecha, $audiencia_id) {
	        $this->id = $id;
		    $this->user = $user;
		    $this->mensaje = $mensaje;
			$this->fecha = $fecha;
		    $this->audiencia_id = $audiencia_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getUser() {
	    	return $this->user;
	    }

	    public function getMensaje() {
	    	return $this->mensaje;
	    }

	    public function getFecha() {
	    	return $this->fecha;
	    }

	    public function getAudiencia_id() {
	    	return $this->audiencia_id;
	    }

	   	public static function get($audiencia_id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM mensaje where audiencia_id = $audiencia_id order by fecha desc";
	    	$rs = $con->query($sql);
	    	$mensajes = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$mensaje = new Mensaje();
			    	$mensaje->put($row["id"], $row["user"], $row["mensaje"], $row["fecha"], $row["audiencia_id"]);
					$mensajes[] = $mensaje;
				}
			$con->close();
			return $mensajes;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "INSERT INTO mensaje (user, mensaje, fecha, audiencia_id) VALUES (?, ?, now(), ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssi", $this->user, $this->mensaje, $this->audiencia_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	}
?>