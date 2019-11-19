<?php
	include_once("Model/Usuario.php");
	include_once("Model/Consumidor.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];
	$aux = null;
	switch($usuario->getRol()) {
		case 'Consumidor':
			$aux = $usuario->consumidor();
			break;
	}
	$_GET["title"] = "Inicio";
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/bulma.css">
		<link rel="stylesheet" type="text/css" href="css/all.css">
	</head>
	<body>
		<?php include("nav.php"); ?>
		<div class="container" style="margin-top: 2em;">
			<div class="columns is-centered">
				<div class="column">
					<div class="card">
						<?php include("header.php"); ?>
						<div class="card-content">
							<div class="content has-text-centered">
								<?php if($usuario->getRol() == 'Consumidor') { ?>
								<h1>Bienvenid<?php echo $aux->getSexo() == "Mujer" ? "a" : "o" ?> <?php echo $aux->getNombre() . ' ' . $aux->getAppaterno() ?></h1>
								<?php } else if($usuario->getRol() == 'Proveedor') { ?>
								<h1>Bienvenido Proveedor</h1>
								<?php } else if($usuario->getRol() == 'Administrador') { ?>
								<h1>Bienvenido Administrador</h1>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>