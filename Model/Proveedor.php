<?php
	include_once("Connection.php");

	class Proveedor {
	 
	 	private $id;
		private $razon;
		private $giro;
		private $usuario_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM proveedor WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->id = $row["id"];
			    $this->razon = $row["razon"];
				$this->giro = $row["giro"];
			    $this->usuario_id = $row["usuario_id"];
			}
			$con->close();
	    }

	    public function charge($razon, $giro, $usuario_id) {
	        $this->razon = $razon;
			$this->giro = $giro;
		    $this->usuario_id = $usuario_id;
	    }

	    public function put($id, $razon, $giro, $usuario_id) {
	        $this->id = $id;
	        $this->razon = $razon;
			$this->giro = $giro;
		    $this->usuario_id = $usuario_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getRazon() {
	    	return $this->razon;
	    }

	    public function getGiro() {
	    	return $this->giro;
	    }

	    public function getUsuario_id() {
	    	return $this->usuario_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM proveedor";
	    	$rs = $con->query($sql);
	    	$proveedores = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$proveedor = new Proveedor();
					$proveedor->put($row["id"], $row["razon"], $row["giro"], $row["usuario_id"]);
					$proveedores[] = $proveedor;
				}
			$con->close();
			return $proveedores;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "INSERT INTO proveedor (razon, giro, usuario_id) VALUES (?, ?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssi", $this->razon, $this->giro, $this->usuario_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($razon, $giro) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "UPDATE proveedor SET razon = ?, giro = ? WHERE id = ?";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssi", $razon, $giro, $this->id);
	    	$aux->execute();
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM proveedor WHERE id = " . $this->id;
	    	$con->query($sql);
			$con->close();
	    }

	    public function usuario() {
	    	$usuario = new Usuario();
	    	$usuario->find($this->usuario_id);
	    	return $usuario;
	    }

	   	public function direccion() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM direccion where proveedor_id = $this->id";
	    	$rs = $con->query($sql);
	    	$direccion = new Direccion();
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $direccion->put($row["id"], $row["calle"], $row["numext"], $row["numint"], $row["estado"], $row["municipio"], $row["colonia"], $row["cp"], $row["persona_id"], $row["proveedor_id"]);
			}
			$con->close();
			return $direccion;
	   	}

	   	public function inconformidades() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM inconformidad where proveedor_id = $this->id and (status = 'Aprovada' || status = 'En proceso')";
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

	    public function __toString() {
	    	return "Proveedor[$this->id] {<br>\trazon: " . $this->razon . "<br>\tgiro: " . $this->giro . "<br>\tusuario_id: " . $this->usuario_id . "<br>}<br>";
	    }

	}
?>