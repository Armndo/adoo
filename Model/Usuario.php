<?php
	include_once("Connection.php");

	class Usuario {
	 
	 	private $id;
		private $email;
		private $password;
		private $rol;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM usuario WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->id = $row["id"];
			    $this->email = $row["email"];
			    $this->password = $row["password"];
			    $this->rol = $row["rol"];
			}
			$con->close();
	    }

	    public function charge($email, $password, $rol) {
	        $this->email = $email;
	        $this->password = $password;
	        $this->rol = $rol;
	    }

	    public function put($id, $email, $password, $rol) {
	    	$this->id = $id;
	        $this->email = $email;
	        $this->password = $password;
	        $this->rol = $rol;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getEmail() {
	    	return $this->email;
	    }

	    public function getPassword() {
	    	return $this->password;
	    }

	    public function getRol() {
	    	return $this->rol;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM usuario";
	    	$rs = $con->query($sql);
	    	$usuarios = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$usuario = new Usuario();
					$usuario->put($row["id"], $row["email"], $row["password"], $row["rol"]);
					$usuarios[] = $usuario;
				}
			$con->close();
			return $usuarios;
	   	}

	   	public static function verify($email, $password) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM usuario WHERE email = '$email' AND password = '$password'";
	    	$rs = $con->query($sql);
	    	$flag = 0;
			if($rs->num_rows > 0)
				while($row = $rs->fetch_assoc())
					$flag = $row["id"];
			$con->close();
			return $flag;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "INSERT INTO usuario (email, password, rol) VALUES ('$this->email', '$this->password', '$this->rol')";
	    	$con->query($sql);
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function update($password) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$this->password = $password;
	    	$sql = "UPDATE usuario SET password = '$this->password' WHERE id = $this->id";
	    	$con->query($sql);
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM usuario WHERE id = $this->id";
	    	$con->query($sql);
			$con->close();
	    }

	   	public function persona() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM persona where usuario_id = $this->id";
	    	$rs = $con->query($sql);
	    	$persona = new Persona();
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $persona->put($row["id"], $row["curp"], $row["nombre"], $row["appaterno"], $row["apmaterno"], $row["sexo"], $row["fecha"], $row["usuario_id"]);
			}
			$con->close();
			return $persona;
	   	}

	   	public function proveedor() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM proveedor where usuario_id = $this->id";
	    	$rs = $con->query($sql);
	    	$proveedor = new Proveedor();
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $proveedor->put($row["id"], $row["razon"], $row["giro"], $row["usuario_id"]);
			}
			$con->close();
			return $proveedor;
	   	}

	    public function __toString() {
	    	return "Usuario[$this->id] {<br>\temail: $this->email<br>\tpassword: $this->password<br>\trol: $this->rol<br>}<br>";
	    }

	}
?>