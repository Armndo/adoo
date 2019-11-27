<?php
	include_once("Connection.php");

	class Inconformidad {
	 
	 	private $id;
		private $status;
		private $estado;
		private $fecha;
		private $tipo;
		private $divisa;
		private $costo;
		private $modo;
		private $descripcion;
		private $consumidor_id;
		private $proveedor_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM inconformidad WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->put($row["id"], $row["status"], $row["estado"], $row["fecha"], $row["tipo"], $row["divisa"], $row["costo"], $row["modo"], $row["descripcion"], $row["consumidor_id"], $row["proveedor_id"]);
			}
			$con->close();
	    }

	    public function charge($estado, $fecha, $tipo, $divisa, $costo, $modo, $descripcion, $consumidor_id, $proveedor_id) {
		    $this->estado = $estado;
		    $this->fecha = $fecha;
		    $this->tipo = $tipo;
		    $this->divisa = $divisa;
		    $this->costo = $costo;
		    $this->modo = $modo;
		    $this->descripcion = $descripcion;
		    $this->consumidor_id = $consumidor_id;
		    $this->proveedor_id = $proveedor_id;
	    }

	    public function put($id, $status, $estado, $fecha, $tipo, $divisa, $costo, $modo, $descripcion, $consumidor_id, $proveedor_id) {
	        $this->id = $id;
		    $this->status = $status;
		    $this->estado = $estado;
		    $this->fecha = $fecha;
		    $this->tipo = $tipo;
		    $this->divisa = $divisa;
		    $this->costo = $costo;
		    $this->modo = $modo;
		    $this->descripcion = $descripcion;
		    $this->consumidor_id = $consumidor_id;
		    $this->proveedor_id = $proveedor_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getStatus() {
	    	return $this->status;
	    }

	    public function getEstado() {
	    	return $this->estado;
	    }

	    public function getFecha() {
	    	return $this->fecha;
	    }

	    public function getTipo() {
	    	return $this->tipo;
	    }

	    public function getDivisa() {
	    	return $this->divisa;
	    }

	    public function getCosto() {
	    	return $this->costo;
	    }

	    public function getModo() {
	    	return $this->modo;
	    }

	    public function getDescripcion() {
	    	return $this->descripcion;
	    }

	    public function getConsumidor_id() {
	    	return $this->consumidor_id;
	    }

	    public function getProveedor_id() {
	    	return $this->proveedor_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM inconformidad where status = 'No Aprovada' or status = 'Aprovada'";
	    	$rs = $con->query($sql);
	    	$inconformidades = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$inconformidad = new Inconformidad();
			    	$inconformidad->put($row["id"], $row["status"], $row["estado"], $row["fecha"], $row["tipo"], $row["divisa"], $row["costo"], $row["modo"], $row["descripcion"], $row["consumidor_id"], $row["proveedor_id"]);
					$inconformidades[] = $inconformidad;
				}
			$con->close();
			return $inconformidades;
	   	}

	   	public static function aprovadas() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM inconformidad where status = 'Aprovada' and id not in(select inconformidad_id from audiencia)";
	    	$rs = $con->query($sql);
	    	$inconformidades = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$inconformidad = new Inconformidad();
			    	$inconformidad->put($row["id"], $row["status"], $row["estado"], $row["fecha"], $row["tipo"], $row["divisa"], $row["costo"], $row["modo"], $row["descripcion"], $row["consumidor_id"], $row["proveedor_id"]);
					$inconformidades[] = $inconformidad;
				}
			$con->close();
			return $inconformidades;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "INSERT INTO inconformidad (estado, fecha, tipo, divisa, costo, modo, descripcion, consumidor_id, proveedor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssssdssii", $this->estado, $this->fecha, $this->tipo, $this->divisa, $this->costo, $this->modo, $this->descripcion, $this->consumidor_id, $this->proveedor_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($status) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "UPDATE inconformidad SET status = ? WHERE id = ?";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("si", $status, $this->id);
	    	$aux->execute();
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM inconformidad WHERE id = " . $this->id;
	    	$con->query($sql);
			$con->close();
	    }

	    public function consumidor() {
	    	$consumidor = new Persona();
	    	$consumidor->find($this->consumidor_id);
	    	return $consumidor;
	    }

	    public function proveedor() {
	    	$proveedor = new Proveedor();
	    	$proveedor->find($this->proveedor_id);
	    	return $proveedor;
	    }

	   	public function documentos() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM documento where inconformidad_id = $this->id";
	    	$rs = $con->query($sql);
	    	$documentos = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$documento = new Documento();
			    	$documento->put($row["id"], $row["url"], $row["inconformidad_id"]);
					$documentos[] = $documento;
				}
			$con->close();
			return $documentos;
	   	}

	    public function __toString() {
	    	return "Inconformidad[$this->id] {<br>status: " . $this->status . "<br>estado: " . $this->estado . "<br>fecha: " . $this->fecha . "<br>tipo: " . $this->tipo . "<br>divisa: " . $this->divisa . "<br>costo: " . $this->costo . "<br>modo: " . $this->modo . "<br>descripcion: " . $this->descripcion . "<br>consumidor_id: " . $this->consumidor_id . "<br>proveedor_id: " . $this->proveedor_id . "<br>}<br>";
	    }

	}
?>