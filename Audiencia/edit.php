<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Proveedor.php");
	include_once("../Model/Audiencia.php");
	include_once("../Model/Inconformidad.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];

	if($usuario->getRol() != "Conciliador")
		header("Location: /proj");

	$aux = new Audiencia();
	$aux->find($_GET["id"]);
	
	$_GET["title"] = "Audiencia";
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
								<form action="../Controller/AudienciaController.php" method="post">
									<input type="hidden" name="action" value="update">
									<input type="hidden" name="id" value="<?php echo $aux->getId() ?>">
									<div class="columns">
										<div class="column is-one-third">
										  	<label class="label">Inconformidad</label>
										  	<div class="control">
								    			<input class="input" type="text" disabled="" value="<?php echo $aux->inconformidad()->getId() . ". " . $aux->inconformidad()->proveedor()->getRazon() . " (" . $aux->inconformidad()->getFecha() . ")" ?>">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Fecha</label>
										  	<div class="control">
								    			<input class="input" name="fecha" type="date" required="" value="<?php echo $aux->getFecha() ?>">
										  	</div>
										</div>
										<div class="column">
										  	<label class="label">Hora</label>
										  	<div class="control">
								    			<input class="input" name="hora" type="time" required="" value="<?php echo $aux->getHora() ?>">
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<div class="control has-text-right">
										  		<button type="submit" class="button is-success">
										  			<p><i class="fas fa-check"></i> Guardar</p>
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