<?php

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