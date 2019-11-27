<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Direccion.php");
	
	$arr = [];
	foreach ($_POST as $key => $value) {
		echo "$key: $value<br>";
	}
	echo "<br>";
	foreach ($_FILES as $file) {
		$arc = new Archivo();
		foreach ($file as $key => $value) {
			$arc->{$key} = $value;
		}
		array_push($arr, $arc);
	}

	$path = "../Archivos/Inconformidad/id/";

	if (!file_exists($path)) {
	    mkdir($path, 0777, true);
	    chmod("../Archivos", 0777);
	}
	
	foreach ($arr as $key => $file) {
		if(is_uploaded_file($file->tmp_name)) {
			if(move_uploaded_file($file->tmp_name, $path . $file->name))
				echo $file->name . " guardado en disco.<br>";
			else
				echo $file->name . " no se guardó en disco.<br>";
		} else
			echo $file->name . " no se pudo subir.<br>";
	}

	class Archivo {

		public $name;
		public $type;
		public $tmp_name;
		public $error;
		public $size;

	    public function __toString() {
	    	return "Archivo {<br>name: " . $this->name . "<br>type: " . $this->type . "<br>tmp_name: " . $this->tmp_name . "<br>error: " . $this->error . "<br>size: " . $this->size . "<br>}<br>";
	    }

	}

?>