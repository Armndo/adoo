<?php
	include_once("Connection.php");

	class Consumidor {
	 
	 	private $id;
		private $curp;
		private $nombre;
		private $appaterno;
		private $apmaterno;
		private $sexo;
		private $fecha;
		private $calle;
		private $numext;
		private $numint;
		private $estado;
		private $municipio;
		private $colonia;
		private $cp;
		private $usuario_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM consumidor WHERE id = " . $id;
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
			    $this->calle = $row["calle"];
			    $this->numext = $row["numext"];
			    $this->numint = $row["numint"];
			    $this->estado = $row["estado"];
			    $this->municipio = $row["municipio"];
			    $this->colonia = $row["colonia"];
			    $this->cp = $row["cp"];
			    $this->usuario_id = $row["usuario_id"];
			}
			$con->close();
	    }

	    public function charge($curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $calle, $numext, $numint, $estado, $municipio, $colonia, $cp, $usuario_id) {
	        $this->curp = $curp;
			$this->nombre = $nombre;
			$this->appaterno = $appaterno;
			$this->apmaterno = $apmaterno;
			$this->sexo = $sexo;
			$this->fecha = $fecha;
		    $this->calle = $calle;
		    $this->numext = $numext;
		    $this->numint = $numint;
		    $this->estado = $estado;
		    $this->municipio = $municipio;
		    $this->colonia = $colonia;
		    $this->cp = $cp;
		    $this->usuario_id = $usuario_id;
	    }

	    public function put($id, $curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $calle, $numext, $numint, $estado, $municipio, $colonia, $cp, $usuario_id) {
	        $this->id = $id;
	        $this->curp = $curp;
			$this->nombre = $nombre;
			$this->appaterno = $appaterno;
			$this->apmaterno = $apmaterno;
			$this->sexo = $sexo;
			$this->fecha = $fecha;
		    $this->calle = $calle;
		    $this->numext = $numext;
		    $this->numint = $numint;
		    $this->estado = $estado;
		    $this->municipio = $municipio;
		    $this->colonia = $colonia;
		    $this->cp = $cp;
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
	    	return $this->usuario_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM consumidor";
	    	$rs = $con->query($sql);
	    	$consumidores = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$consumidor = new Consumidor();
					$consumidor->put($row["id"], $row["curp"], $row["nombre"], $row["appaterno"], $row["apmaterno"], $row["sexo"], $row["fecha"], $row["calle"], $row["numext"], $row["numint"], $row["estado"], $row["municipio"], $row["colonia"], $row["cp"], $row["usuario_id"]);
					$consumidores[] = $consumidor;
				}
			$con->close();
			return $consumidores;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$numint = $this->numint == "" ? null : $this->numint;
	    	$apmaterno = $this->apmaterno == "" ? null : $this->apmaterno;
	    	$sql = "INSERT INTO consumidor (curp, nombre, appaterno, apmaterno, sexo, fecha, calle, numext, numint, estado, municipio, colonia, cp, usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("sssssssiissssi", $this->curp, $this->nombre, $this->appaterno, $apmaterno, $this->sexo, $this->fecha, $this->calle, $this->numext, $numint, $this->estado, $this->municipio, $this->colonia, $this->cp, $this->usuario_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $calle, $numext, $numint, $estado, $municipio, $colonia, $cp) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$numint = $numint == "" ? null : $numint;
	    	$apmaterno = $apmaterno == "" ? null : $apmaterno;
	    	$sql = "UPDATE consumidor SET curp = ?, nombre = ?, appaterno = ?, apmaterno = ?, sexo = ?, fecha = ?, calle = ?, numext = ?, numint = ?, estado = ?, municipio = ?, colonia = ?, cp = ? WHERE id = ?";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("sssssssiissssi", $curp, $nombre, $appaterno, $apmaterno, $sexo, $fecha, $calle, $numext, $numint, $estado, $municipio, $colonia, $cp, $this->id);
	    	$aux->execute();
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM consumidor WHERE id = " . $this->id;
	    	$con->query($sql);
			$con->close();
	    }

	    public function usuario() {
	    	$usuario = new Usuario();
	    	$usuario->find($this->usuario_id);
	    	return $usuario;
	    }

	    public function __toString() {
	    	return "Consumidor[$this->id] {<br>\tcurp: " . $this->curp . "<br>\tnombre: " . $this->nombre . "<br>\tappaterno: " . $this->appaterno . "<br>\tapmaterno: " . $this->apmaterno . "<br>\tsexo: " . $this->sexo . "<br>\tfecha: " . $this->fecha . "<br>\tcalle: " . $this->calle . "<br>\tnumext: " . $this->numext . "<br>\tnumint: " . $this->numint . "<br>\testado: " . $this->estado . "<br>\tmunicipio: " . $this->municipio . "<br>\tcolonia: " . $this->colonia . "<br>\tcp: " . $this->cp . "<br>\tusuario_id: " . $this->usuario_id . "<br>}<br>";
	    }

	}
?>