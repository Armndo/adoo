<?php
	include_once("Connection.php");

	class Audiencia {
	 
	 	private $id;
		private $status;
		private $fecha;
		private $hora;
		private $inconformidad_id;
		private $conciliador_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM audiencia WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->put($row["id"], $row["status"], $row["fecha"], $row["hora"], $row["inconformidad_id"], $row["conciliador_id"]);
			}
			$con->close();
	    }

	    public function charge($fecha, $hora, $inconformidad_id, $conciliador_id) {
		    $this->fecha = $fecha;
		    $this->hora = $hora;
		    $this->inconformidad_id = $inconformidad_id;
		    $this->conciliador_id = $conciliador_id;
	    }

	    public function put($id, $status, $fecha, $hora, $inconformidad_id, $conciliador_id) {
	        $this->id = $id;
		    $this->status = $status;
		    $this->fecha = $fecha;
		    $this->hora = $hora;
		    $this->inconformidad_id = $inconformidad_id;
		    $this->conciliador_id = $conciliador_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getStatus() {
	    	return $this->status;
	    }

	    public function getFecha() {
	    	return $this->fecha;
	    }

	    public function getHora() {
	    	return $this->hora;
	    }

	    public function getInconformidad_id() {
	    	return $this->inconformidad_id;
	    }

	    public function getConciliador_id() {
	    	return $this->conciliador_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM audiencia";
	    	$rs = $con->query($sql);
	    	$audiencias = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$audiencia = new Audiencia();
			    	$audiencia->put($row["id"], $row["status"], $row["fecha"], $row["hora"], $row["inconformidad_id"], $row["conciliador_id"]);
					$audiencias[] = $audiencia;
				}
			$con->close();
			return $audiencias;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "INSERT INTO audiencia (fecha, hora, inconformidad_id, conciliador_id) VALUES (?, ?, ?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssii", $this->fecha, $this->hora, $this->inconformidad_id, $this->conciliador_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($fecha, $hora) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "UPDATE audiencia SET fecha = ?, hora = ? WHERE id = ?";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssi", $fecha, $hora, $this->id);
	    	$aux->execute();
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM audiencia WHERE id = " . $this->id;
	    	$con->query($sql);
			$con->close();
	    }

	    public function conciliador() {
	    	$conciliador = new Persona();
	    	$conciliador->find($this->conciliador_id);
	    	return $conciliador;
	    }

	    public function inconformidad() {
	    	$inconformidad = new Inconformidad();
	    	$inconformidad->find($this->inconformidad_id);
	    	return $inconformidad;
	    }

	    public function __toString() {
	    	return "Audiencia[$this->id] {<br>status: " . $this->status . "<br>fecha: " . $this->fecha . "<br>hora: " . $this->hora . "<br>inconformidad_id: " . $this->inconformidad_id . "<br>conciliador_id: " . $this->conciliador_id . "<br>}<br>";
	    }

	}
?>