<?php
	include_once("Connection.php");

	class Documento {
	 
	 	private $id;
		private $url;
		private $inconformidad_id;

	    public function find($id) {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM documento WHERE id = " . $id;
	    	$rs = $con->query($sql);
			if ($rs->num_rows > 0) {
			    $row = $rs->fetch_assoc();
			    $this->put($row["id"], $row["url"], $row["inconformidad_id"]);
			}
			$con->close();
	    }

	    public function charge($url, $inconformidad_id) {
		    $this->url = $url;
		    $this->inconformidad_id = $inconformidad_id;
	    }

	    public function put($id, $url, $inconformidad_id) {
	        $this->id = $id;
		    $this->url = $url;
		    $this->inconformidad_id = $inconformidad_id;
	    }

	    public function getId() {
	    	return $this->id;
	    }

	    public function getUrl() {
	    	return $this->url;
	    }

	    public function getInconformidad_id() {
	    	return $this->inconformidad_id;
	    }

	   	public static function get() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "SELECT * FROM documento";
	    	$rs = $con->query($sql);
	    	$documentoes = [];
			if ($rs->num_rows > 0)
				while($row = $rs->fetch_assoc()) {
					$documento = new Documento();
			    	$documento->put($row["id"], $row["url"], $row["inconformidad_id"]);
					$documentoes[] = $documento;
				}
			$con->close();
			return $documentoes;
	   	}

	    public function commit() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "INSERT INTO documento (url, inconformidad_id) VALUES (?, ?)";
	    	$aux = $con->prepare($sql);
	    	$aux->bind_param("si", $this->url, $this->inconformidad_id);
	    	$aux->execute();
	    	$this->id = $con->insert_id;
		    echo $con->error;
			$con->close();
	    }

	    public function destroy() {
	    	$con = new Connection();
	    	$con = $con->getConnection();
	    	$sql = "DELETE FROM documento WHERE id = " . $this->id;
	    	$con->query($sql);
			$con->close();
	    }

	    public function inconformidad() {
	    	$inconformidad = new Inconformidad();
	    	$inconformidad->find($this->inconformidad_id);
	    	return $inconformidad;
	    }

	    public function __toString() {
	    	return "Documento[$this->id] {<br>url: " . $this->url . "<br>inconformidad_id: " . $this->inconformidad_id . "<br>}<br>";
	    }

	}
?>