<?php
	include_once("Connection.php");

	class Direccion {
	 
	 	private $id;
		private $calle;
		private $numext;
		private $numint;
		private $estado;
		private $municipio;
		private $colonia;
		private $cp;
		private $persona_id;
		private $proveedor_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM direccion WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->id = $row["id"];
			    $this->calle = $row["calle"];
			    $this->numext = $row["numext"];
			    $this->numint = $row["numint"];
			    $this->estado = $row["estado"];
			    $this->municipio = $row["municipio"];
			    $this->colonia = $row["colonia"];
			    $this->cp = $row["cp"];
			    $this->persona_id = $row["persona_id"];
			    $this->proveedor_id = $row["proveedor_id"];
			}
			$con->close();
	    }

	    public function charge($calle, $numext, $numint, $estado, $municipio, $colonia, $cp, $persona_id, $proveedor_id) {
		    $this->calle = $calle;
		    $this->numext = $numext;
		    $this->numint = $numint;
		    $this->estado = $estado;
		    $this->municipio = $municipio;
		    $this->colonia = $colonia;
		    $this->cp = $cp;
		    $this->persona_id = $persona_id;
		    $this->proveedor_id = $proveedor_id;
	    }

	    public function put($id, $calle, $numext, $numint, $estado, $municipio, $colonia, $cp, $persona_id, $proveedor_id) {
	        $this->id = $id;
		    $this->calle = $calle;
		    $this->numext = $numext;
		    $this->numint = $numint;
		    $this->estado = $estado;
		    $this->municipio = $municipio;
		    $this->colonia = $colonia;
		    $this->cp = $cp;
		    $this->persona_id = $persona_id;
		    $this->proveedor_id = $proveedor_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getCalle() {
	    	return $this->calle;
	    }

	    public function getNumext() {
	    	return $this->numext;
	    }

	    public function getNumint() {
	    	return $this->numint;
	    }

	    public function getEstado() {
	    	return $this->estado;
	    }

	    public function getMunicipio() {
	    	return $this->municipio;
	    }

	    public function getColonia() {
	    	return $this->colonia;
	    }

	    public function getCp() {
	    	return $this->cp;
	    }

	    public function getUsuario_id() {
	    	return $this->persona_id;
	    }

	    public function getProveedor_id() {
	    	return $this->proveedor_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM direccion";
	    	$rs = $con->query($sql);
	    	$direcciones = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$direccion = new Direccion();
					$direccion->put($row["id"], $row["calle"], $row["numext"], $row["numint"], $row["estado"], $row["municipio"], $row["colonia"], $row["cp"], $row["persona_id"], $row["proveedor_id"]);
					$direcciones[] = $direccion;
				}
			$con->close();
			return $direcciones;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$numint = $this->numint == "" ? null : $this->numint;
	    	$persona_id = $this->persona_id == "" ? null : $this->persona_id;
	    	$proveedor_id = $this->proveedor_id == "" ? null : $this->proveedor_id;
	    	$sql = "INSERT INTO direccion (calle, numext, numint, estado, municipio, colonia, cp, persona_id, proveedor_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("siissssii", $this->calle, $this->numext, $numint, $this->estado, $this->municipio, $this->colonia, $this->cp, $persona_id, $proveedor_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($calle, $numext, $numint, $estado, $municipio, $colonia, $cp) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$numint = $numint == "" ? null : $numint;
	    	$sql = "UPDATE direccion SET calle = ?, numext = ?, numint = ?, estado = ?, municipio = ?, colonia = ?, cp = ? WHERE id = ?";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("siissssi", $calle, $numext, $numint, $estado, $municipio, $colonia, $cp, $this->id);
	    	$aux->execute();
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM direccion WHERE id = " . $this->id;
	    	$con->query($sql);
			$con->close();
	    }

	    public function persona() {
	    	$persona = new Persona();
	    	$persona->find($this->persona_id);
	    	return $persona;
	    }

	    public function proveedor() {
	    	$proveedor = new Proveedor();
	    	$proveedor->find($this->proveedor_id);
	    	return $proveedor;
	    }

	    public function __toString() {
	    	return "Direccion[$this->id] {<br>\tcalle: " . $this->calle . "<br>\tnumext: " . $this->numext . "<br>\tnumint: " . $this->numint . "<br>\testado: " . $this->estado . "<br>\tmunicipio: " . $this->municipio . "<br>\tcolonia: " . $this->colonia . "<br>\tpersona_id: " . $this->persona_id . "<br>\tcp: " . $this->cp . "<br>\tproveedor_id: " . $this->proveedor_id . "<br>}<br>";
	    }

	}
?>