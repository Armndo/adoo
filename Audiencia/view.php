<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Proveedor.php");
	include_once("../Model/Inconformidad.php");
	include_once("../Model/Audiencia.php");

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
								<input type="hidden" name="action" value="store">
								<div class="columns">
									<div class="column is-one-third">
									  	<label class="label">Inconformidad</label>
									  	<div class="control">
							    			<input class="input" name="fecha" type="text" required="" disabled="" value="<?php echo $aux->inconformidad()->getId() . ". " . $aux->inconformidad()->proveedor()->getRazon() . " (" . $aux->inconformidad()->getFecha() . ")" ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Fecha</label>
									  	<div class="control">
							    			<input class="input" name="fecha" type="date" required="" disabled="" value="<?php echo $aux->getFecha() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Hora</label>
									  	<div class="control">
							    			<input class="input" name="hora" type="time" required="" disabled="" value="<?php echo $aux->getHora() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<div class="control has-text-right">
									  		<a href="edit.php?id=<?php echo $aux->getId() ?>" class="button is-warning">
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