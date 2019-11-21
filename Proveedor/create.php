<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Proveedor.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];

	if($usuario->getRol() != "Administrador")
		header("Location: /proj");

	$_GET["title"] = "Proveedor";
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
								<form action="../Controller/ProveedorController.php" method="post">
									<input type="hidden" name="action" value="store">
									<div class="columns">
										<div class="column is-one-third">
										  	<label class="label">Correo electrónico</label>
										  	<div class="control">
								    			<input class="input" name="email" type="text" required="">
										  	</div>
										</div>
										<div class="column is-one-third">
										  	<label class="label">Contraseña</label>
										  	<div class="control">
								    			<input class="input" name="password" type="text" required="">
										  	</div>
										</div>
									</div>
									<h3 class="title is-5">Datos del Proveedor</h3>
									<div class="columns">
										<div class="column is-one-third">
										  	<label class="label">Razón social</label>
										  	<div class="control">
								    			<input class="input" name="razon" type="text" required="">
										  	</div>
										</div>
										<div class="column is-one-third">
										  	<label class="label">Giro</label>
										  	<div class="control">
								    			<input class="input" name="giro" type="text" required="">
										  	</div>
										</div>
									</div>
									<h3 class="title is-5">Domicilio</h3>
									<div class="columns">
										<div class="column">
										  	<label class="label">Calle</label>
										  	<div class="control">
								    			<input class="input" name="calle" type="text" required="">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Número exterior</label>
										  	<div class="control">
								    			<input class="input" name="numext" type="number" min="1" step="1" required="">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Número interior</label>
										  	<div class="control">
								    			<input class="input" name="numint" type="number" min="1" step="1">
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<label class="label">Estado</label>
										  	<div class="select" style="width: 100%;">
										  		<select class="input" name="estado" required="">
								    				<option value="">Selecciona</option>
									    			<option value="Aguascalientes">Aguascalientes</option>
													<option value="Baja California">Baja California</option>
													<option value="Baja California Sur">Baja California Sur</option>
													<option value="Campeche">Campeche</option>
													<option value="Ciudad de México">Ciudad de México</option>
													<option value="Chihuahua">Chihuahua</option>
													<option value="Chiapas">Chiapas</option>
													<option value="Coahuila">Coahuila</option>
													<option value="Colima">Colima</option>
													<option value="Durango">Durango</option>
													<option value="Guanajuato">Guanajuato</option>
													<option value="Guerrero">Guerrero</option>
													<option value="Hidalgo">Hidalgo</option>
													<option value="Jalisco">Jalisco</option>
													<option value="México">México</option>
													<option value="Michoacán">Michoacán</option>
													<option value="Morelos">Morelos</option>
													<option value="Nayarit">Nayarit</option>
													<option value="Nuevo León">Nuevo León</option>
													<option value="Oaxaca">Oaxaca</option>
													<option value="Puebla">Puebla</option>
													<option value="Querétaro">Querétaro</option>
													<option value="Quintana">Roo Quintana Roo</option>
													<option value="San Luis Potosí">San Luis Potosí</option>
													<option value="Sinaloa">Sinaloa</option>
													<option value="Sonora">Sonora</option>
													<option value="Tabasco">Tabasco</option>
													<option value="Tamaulipas">Tamaulipas</option>
													<option value="Tlaxcala">Tlaxcala</option>
													<option value="Veracruz">Veracruz</option>
													<option value="Yucatán">Yucatán</option>
													<option value="Zacatecas">Zacatecas</option>
										  		</select>
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Municipio/Alcaldía</label>
										  	<div class="control">
								    			<input class="input" name="municipio" type="text" required="">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Colonia</label>
										  	<div class="control">
								    			<input class="input" name="colonia" type="text" required="">
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column is-one-third">
										  	<label class="label">Código postal</label>
										  	<div class="control">
								    			<input class="input" name="cp" type="text" required="">
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<div class="control has-text-right">
										  		<button type="submit" class="button is-success">
										  			<p><i class="fas fa-check"></i> Registrar</p>
										  		</button>
										  	</div>
										</div>	
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>