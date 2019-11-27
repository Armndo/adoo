<?php
	include_once("Connection.php");

	class Persona {
	 
	 	private $id;
		private $curp;
		private $nombre;
		private $appaterno;
		private $apmaterno;
		private $sexo;
		private $fecha;
		private $usuario_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM persona WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->id = $row["id"];
			    $this->curp = $row["curp"];
				$this->nombre = $row["nombre"];
				$this->appaterno = $row["appaterno"];
				$this->apmaterno = $row["apmaterno"];
				$this->sexo = $row["sexo"];
				$this->fecha = $row["fecha"];
			    $this->usuario_id = $row["usuario_id"];
			}
			$con->close();
	    }

	    public function charge($curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $usuario_id) {
	        $this->curp = $curp;
			$this->nombre = $nombre;
			$this->appaterno = $appaterno;
			$this->apmaterno = $apmaterno;
			$this->sexo = $sexo;
			$this->fecha = $fecha;
		    $this->usuario_id = $usuario_id;
	    }

	    public function put($id, $curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $usuario_id) {
	    	$this->id = $id;
	        $this->curp = $curp;
			$this->nombre = $nombre;
			$this->appaterno = $appaterno;
			$this->apmaterno = $apmaterno;
			$this->sexo = $sexo;
			$this->fecha = $fecha;
		    $this->usuario_id = $usuario_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getCurp() {
	    	return $this->curp;
	    }

	    public function getNombre() {
	    	return $this->nombre;
	    }

	    public function getAppaterno() {
	    	return $this->appaterno;
	    }

	    public function getApmaterno() {
	    	return $this->apmaterno;
	    }

	    public function getSexo() {
	    	return $this->sexo;
	    }

	    public function getFecha() {
	    	return $this->fecha;
	    }

	    public function getUsuario_id() {
	    	return $this->usuario_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM persona";
	    	$rs = $con->query($sql);
	    	$personas = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$persona = new Persona();
					$persona->put($row["id"], $row["curp"], $row["nombre"], $row["appaterno"], $row["apmaterno"], $row["sexo"], $row["fecha"], $row["usuario_id"]);
					$personas[] = $persona;
				}
			$con->close();
			return $personas;
	   	}

	   	public static function consumidores() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT persona.id as id, curp, nombre, appaterno, apmaterno, sexo, fecha, usuario_id FROM persona join usuario on usuario.id = usuario_id where rol = 'Consumidor'";
	    	$rs = $con->query($sql);
	    	$personas = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$persona = new Persona();
					$persona->put($row["id"], $row["curp"], $row["nombre"], $row["appaterno"], $row["apmaterno"], $row["sexo"], $row["fecha"], $row["usuario_id"]);
					$personas[] = $persona;
				}
			$con->close();
			return $personas;
	   	}

	   	public static function conciliadores() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT persona.id as id, curp, nombre, appaterno, apmaterno, sexo, fecha, usuario_id FROM persona join usuario on usuario.id = usuario_id where rol = 'Conciliador'";
	    	$rs = $con->query($sql);
	    	$personas = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$persona = new Persona();
					$persona->put($row["id"], $row["curp"], $row["nombre"], $row["appaterno"], $row["apmaterno"], $row["sexo"], $row["fecha"], $row["usuario_id"]);
					$personas[] = $persona;
				}
			$con->close();
			return $personas;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$apmaterno = $this->apmaterno == "" ? null : $this->apmaterno;
	    	$sql = "INSERT INTO persona (curp, nombre, appaterno, apmaterno, sexo, fecha, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssssssi", $this->curp, $this->nombre, $this->appaterno, $apmaterno, $this->sexo, $this->fecha, $this->usuario_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$apmaterno = $apmaterno == "" ? null : $apmaterno;
	    	$sql = "UPDATE persona SET curp = ?, nombre = ?, appaterno = ?, apmaterno = ?, sexo = ?, fecha = ? WHERE id = ?";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("ssssssi", $curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $this->id);
	    	$aux->execute();
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM persona WHERE id = " . $this->id;
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
	    	$sql = "SELECT * FROM direccion where persona_id = $this->id";
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
	    	$sql = "SELECT * FROM inconformidad where consumidor_id = $this->id";
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
	    	return "Persona[$this->id] {<br>\tcurp: " . $this->curp . "<br>\tnombre: " . $this->nombre . "<br>\tappaterno: " . $this->appaterno . "<br>\tapmaterno: " . $this->apmaterno . "<br>\tsexo: " . $this->sexo . "<br>\tfecha: " . $this->fecha . "<br>\tusuario_id: " . $this->usuario_id . "<br>}<br>";
	    }

	}
?>