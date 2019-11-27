<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Proveedor.php");
	include_once("../Model/Inconformidad.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];

	if($usuario->getRol() != "Consumidor")
		header("Location: /proj");

	$_GET["title"] = "Inconformidad";
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
								<form action="../Controller/TestController.php" method="post" enctype="multipart/form-data">
									<input type="hidden" name="action" value="store">
									<div class="columns">
										<div class="column is-one-third">
										  	<label class="label">Proveedor</label>
										  	<div class="select" style="width: 100%;">
										  		<select class="input" name="proveedor_id" required="">
								    				<option value="">Selecciona</option>
								    				<?php foreach(Proveedor::get() as $proveedor) { ?>
									    				<option value="<?php echo $proveedor->getId() ?>"><?php echo $proveedor->getRazon() ?></option>
													<?php } ?>
										  		</select>
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<label class="label">Lugar</label>
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
										  	<label class="label">Fecha</label>
										  	<div class="control">
								    			<input class="input" name="fecha" type="date" required="">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Tipo de pago</label>
										  	<div class="select" style="width: 100%;">
										  		<select class="input" name="tipo" required="">
								    				<option value="">Selecciona</option>
									    			<option value="Cheque">Cheque</option>
													<option value="Crédito de la tienda">Crédito de la tienda</option>
													<option value="Depósito a cuenta bancaria">Depósito a cuenta bancaria</option>
													<option value="Efectivo">Efectivo</option>
													<option value="Giro postal o telegráfico">Giro postal o telegráfico</option>
													<option value="Ninguna">Ninguna</option>
													<option value="Nota de crédito">Nota de crédito</option>
													<option value="Puntos">Puntos</option>
													<option value="Servicio de pago en línea">Servicio de pago en línea</option>
													<option value="Tarjeta de crédito">Tarjeta de crédito</option>
													<option value="Tarjeta de crédito de la tienda">Tarjeta de crédito de la tienda</option>
													<option value="Tarjeta de débito">Tarjeta de débito</option>
													<option value="Transferencia bancaria">Transferencia bancaria</option>
													<option value="Vales">Vales</option>
										  		</select>
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<label class="label">Divisa</label>
										  	<div class="select" style="width: 100%;">
										  		<select class="input" name="divisa" required="">
								    				<option value="">Selecciona</option>
									    			<option value="Pesos">Pesos</option>
													<option value="Dólares">Dólares</option>
													<option value="Euros">Euros</option>
										  		</select>
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Costo</label>
										  	<div class="control">
								    			<input class="input" name="costo" type="number" min="0" step="0.01" required="">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Modalidad de compra</label>
										  	<div class="select" style="width: 100%;">
										  		<select class="input" name="modo" required="">
								    				<option value="">Selecciona</option>
									    			<option value="A domicilio">A domicilio</option>
													<option value="En establecimiento físico">En establecimiento físico</option>
													<option value="Por correo">Por correo</option>
													<option value="Por internet">Por internet</option>
													<option value="Por teléfono">Por teléfono</option>
													<option value="Imposición del proveedor">Imposición del proveedor</option>
										  		</select>
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<label class="label">Descripción</label>
										  	<div class="control">
										  		<textarea class="textarea" name="descripcion" required="" maxlength="65535"></textarea>
										  	</div>
										</div>
									</div>
									<div id="files"></div>
									<div class="columns">
										<div class="column">
											<button type="button" class="button" onclick="addFile()">
												<p><i class="fas fa-plus"></i> Agregar archivo</p>
											</button>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<div class="control has-text-right">
										  		<button type="submit" class="button is-success">
										  			<p><i class="fas fa-check"></i> Generar</p>
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
<script type="text/javascript">
	
	let index = 0;
	let arr = [];

	function addFile() {
		let files = document.getElementById('files');
		let columns = document.createElement('div');
		let column1 = document.createElement('div');
		let column2 = document.createElement('div');
		let file = document.createElement('input');
		let button = document.createElement('button');
		let i = index++;
		file.type = 'file';
		file.name = 'file' + i;
		file.class = 'input';
		file.required = true;
		button.type = 'button';
		button.onclick = function() { removeFile(i); };
		button.innerHTML = '<p><i class="fas fa-times"></i> Eliminar</p>';
		button.classList.add('button');
		button.classList.add('is-danger');
		button.classList.add('is-small');
		column1.classList.add('column');
		column2.classList.add('column');
		column2.classList.add('has-text-right');
		columns.classList.add('columns');
		column1.appendChild(file);
		column2.appendChild(button);
		columns.appendChild(column1);
		columns.appendChild(column2);
		arr[i] = columns;
		updateFiles();
	}

	function removeFile(i) {
		arr[i] = null;
		updateFiles();
	}

	function updateFiles() {
		console.log(arr)
		files.innerHTML = "";
		arr.forEach(e => {
			if(e != null) {
  				files.appendChild(e);
			}
		});
	}

</script>