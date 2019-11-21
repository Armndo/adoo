<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Direccion.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];

	if($usuario->getRol() != "Conciliador" && $usuario->getRol() != "Administrador")
		header("Location: /proj");

	$aux = null;
	$direccion = null;
	switch($usuario->getRol()) {
		case 'Conciliador':
			$aux = $usuario->persona();
			$_GET["title"] = "Perfil";
			break;
		default:
			$aux = new Persona();
			$aux->find($_GET["id"]);
			$_GET["title"] = "Conciliador";
			break;
	}
	if($aux != null)
		$direccion = $aux->direccion();
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="../css/bulma.css">
		<link rel="stylesheet" type="text/css" href="../css/all.css">
	</head>
	<body>
		<?php include("../nav.php"); ?>
		<div class="container" style="margin-top: 2em;">
			<div class="columns is-centered">
				<div class="column">
					<div class="card">
						<?php include("../header.php"); ?>
						<div class="card-content">
							<div class="content">
								<h3 class="title is-5">Datos de sesión</h3>
								<div class="columns is-left">
									<div class="column is-one-third">
									  	<label class="label">Correo electrónico</label>
									  	<div class="control">
							    			<input class="input" name="email" type="text" required="" disabled="" value="<?php echo $aux->usuario()->getEmail() ?>">
									  	</div>
									</div>
									<div class="column is-one-third">
									  	<label class="label">Contraseña</label>
									  	<div class="control">
							    			<input class="input" name="password" type="text" required="" disabled="" value="<?php echo $aux->usuario()->getPassword() ?>">
									  	</div>
									</div>
								</div>
								<h3 class="title is-5">Datos Personales</h3>
								<div class="columns">
									<div class="column">
									  	<label class="label">CURP</label>
									  	<div class="control">
							    			<input class="input" name="curp" type="text" required="" disabled="" value="<?php echo $aux->getCurp() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Nombre</label>
									  	<div class="control">
							    			<input class="input" name="nombre" type="text" required="" disabled="" value="<?php echo $aux->getNombre() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Apellido paterno</label>
									  	<div class="control">
							    			<input class="input" name="appaterno" type="text" required="" disabled="" value="<?php echo $aux->getAppaterno() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<label class="label">Apellido materno</label>
									  	<div class="control">
							    			<input class="input" name="apmaterno" type="text" disabled="" value="<?php echo $aux->getApmaterno() != null ? $aux->getApmaterno() : "N/A" ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Sexo</label>
									  	<div class="" style="width: 100%;">
									  		<select class="input" name="sexo" required="" disabled="">
									  			<option value="">Selecciona</option>
									  			<option value="Hombre"<?php echo $aux->getSexo() == "Hombre" ? " selected=''" : "" ?>>Hombre</option>
									  			<option value="Mujer"<?php echo $aux->getSexo() == "Mujer" ? " selected=''" : "" ?>>Mujer</option>
									  		</select>
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Fecha de nacimiento</label>
									  	<div class="control">
							    			<input class="input" name="fecha" type="date" required="" disabled="" value="<?php echo $aux->getFecha() ?>">
									  	</div>
									</div>
								</div>
								<h3 class="title is-5">Domicilio</h3>
								<div class="columns">
									<div class="column">
									  	<label class="label">Calle</label>
									  	<div class="control">
							    			<input class="input" name="calle" type="text" required="" disabled="" value="<?php echo $direccion->getCalle() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Número exterior</label>
									  	<div class="control">
							    			<input class="input" name="numext" type="text" required="" disabled="" value="<?php echo $direccion->getNumext() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Número interior</label>
									  	<div class="control">
							    			<input class="input" name="numint" type="text" disabled="" value="<?php echo $direccion->getNumint() != null ? $direccion->getNumint() : "N/A" ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<label class="label">Estado</label>
									  	<div class="" style="width: 100%;">
									  		<select class="input" name="estado" required="" disabled="">
							    				<option value="">Selecciona</option>
								    			<option value="Aguascalientes"<?php echo $direccion->getEstado() == "Aguascalientes" ? " selected=''" : "" ?>>Aguascalientes</option>
												<option value="Baja California"<?php echo $direccion->getEstado() == "Baja California" ? " selected=''" : "" ?>>Baja California</option>
												<option value="Baja California Sur"<?php echo $direccion->getEstado() == "Baja California Sur" ? " selected=''" : "" ?>>Baja California Sur</option>
												<option value="Campeche"<?php echo $direccion->getEstado() == "Campeche" ? " selected=''" : "" ?>>Campeche</option>
												<option value="Ciudad de México"<?php echo $direccion->getEstado() == "Ciudad de México" ? " selected=''" : "" ?>>Ciudad de México</option>
												<option value="Chihuahua"<?php echo $direccion->getEstado() == "Chihuahua" ? " selected=''" : "" ?>>Chihuahua</option>
												<option value="Chiapas"<?php echo $direccion->getEstado() == "Chiapas" ? " selected=''" : "" ?>>Chiapas</option>
												<option value="Coahuila"<?php echo $direccion->getEstado() == "Coahuila" ? " selected=''" : "" ?>>Coahuila</option>
												<option value="Colima"<?php echo $direccion->getEstado() == "Colima" ? " selected=''" : "" ?>>Colima</option>
												<option value="Durango"<?php echo $direccion->getEstado() == "Durango" ? " selected=''" : "" ?>>Durango</option>
												<option value="Guanajuato"<?php echo $direccion->getEstado() == "Guanajuato" ? " selected=''" : "" ?>>Guanajuato</option>
												<option value="Guerrero"<?php echo $direccion->getEstado() == "Guerrero" ? " selected=''" : "" ?>>Guerrero</option>
												<option value="Hidalgo"<?php echo $direccion->getEstado() == "Hidalgo" ? " selected=''" : "" ?>>Hidalgo</option>
												<option value="Jalisco"<?php echo $direccion->getEstado() == "Jalisco" ? " selected=''" : "" ?>>Jalisco</option>
												<option value="México"<?php echo $direccion->getEstado() == "México" ? " selected=''" : "" ?>>México</option>
												<option value="Michoacán"<?php echo $direccion->getEstado() == "Michoacán" ? " selected=''" : "" ?>>Michoacán</option>
												<option value="Morelos"<?php echo $direccion->getEstado() == "Morelos" ? " selected=''" : "" ?>>Morelos</option>
												<option value="Nayarit"<?php echo $direccion->getEstado() == "Nayarit" ? " selected=''" : "" ?>>Nayarit</option>
												<option value="Nuevo León"<?php echo $direccion->getEstado() == "Nuevo León" ? " selected=''" : "" ?>>Nuevo León</option>
												<option value="Oaxaca"<?php echo $direccion->getEstado() == "Oaxaca" ? " selected=''" : "" ?>>Oaxaca</option>
												<option value="Puebla"<?php echo $direccion->getEstado() == "Puebla" ? " selected=''" : "" ?>>Puebla</option>
												<option value="Querétaro"<?php echo $direccion->getEstado() == "Querétaro" ? " selected=''" : "" ?>>Querétaro</option>
												<option value="Quintana"<?php echo $direccion->getEstado() == "Quintana" ? " selected=''" : "" ?>>Roo Quintana Roo</option>
												<option value="San Luis Potosí"<?php echo $direccion->getEstado() == "San Luis Potosí" ? " selected=''" : "" ?>>San Luis Potosí</option>
												<option value="Sinaloa"<?php echo $direccion->getEstado() == "Sinaloa" ? " selected=''" : "" ?>>Sinaloa</option>
												<option value="Sonora"<?php echo $direccion->getEstado() == "Sonora" ? " selected=''" : "" ?>>Sonora</option>
												<option value="Tabasco"<?php echo $direccion->getEstado() == "Tabasco" ? " selected=''" : "" ?>>Tabasco</option>
												<option value="Tamaulipas"<?php echo $direccion->getEstado() == "Tamaulipas" ? " selected=''" : "" ?>>Tamaulipas</option>
												<option value="Tlaxcala"<?php echo $direccion->getEstado() == "Tlaxcala" ? " selected=''" : "" ?>>Tlaxcala</option>
												<option value="Veracruz"<?php echo $direccion->getEstado() == "Veracruz" ? " selected=''" : "" ?>>Veracruz</option>
												<option value="Yucatán"<?php echo $direccion->getEstado() == "Yucatán" ? " selected=''" : "" ?>>Yucatán</option>
												<option value="Zacatecas"<?php echo $direccion->getEstado() == "Zacatecas" ? " selected=''" : "" ?>>Zacatecas</option>
									  		</select>
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Municipio/Alcaldía</label>
									  	<div class="control">
							    			<input class="input" name="municipio" type="text" required="" disabled="" value="<?php echo $direccion->getMunicipio() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Colonia</label>
									  	<div class="control">
							    			<input class="input" name="colonia" type="text" required="" disabled="" value="<?php echo $direccion->getColonia() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column is-one-third">
									  	<label class="label">Código postal</label>
									  	<div class="control">
							    			<input class="input" name="cp" type="text" required="" disabled="" value="<?php echo $direccion->getCp() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<div class="control has-text-right">
									  		<a class="button is-warning" href="edit.php<?php echo ($usuario->getRol() == 'Administrador' ? '?id='. $aux->getId() : '') ?>">
									  			<p><i class="fas fa-pencil-alt"></i> Editar</p>
									  		</a>
									  	</div>
									</div>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>