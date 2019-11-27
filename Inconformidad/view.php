<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Proveedor.php");
	include_once("../Model/Inconformidad.php");
	include_once("../Model/Documento.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];

	if($usuario->getRol() == "Administrador")
		header("Location: /proj");

	$aux = new Inconformidad();
	$aux->find($_GET["id"]);
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
								<div class="columns">
									<div class="column is-one-third">
									  	<label class="label">Proveedor</label>
									  	<div class="control">
									  		<input class="input" type="text" disabled="" value="<?php echo $aux->proveedor()->getRazon() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<label class="label">Lugar</label>
									  	<div class="control">
									  		<input class="input" type="text" disabled="" value="<?php echo $aux->getEstado() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Fecha</label>
									  	<div class="control">
							    			<input class="input" name="fecha" type="date" required="" disabled="" value="<?php echo $aux->getFecha() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Tipo de pago</label>
									  	<div class="control">
									  		<input class="input" type="text" disabled="" value="<?php echo $aux->getTipo() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<label class="label">Divisa</label>
									  	<div class="control">
									  		<input type="text" class="input" disabled="" value="<?php echo $aux->getDivisa() ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Costo</label>
									  	<div class="control">
							    			<input class="input" name="costo" type="text" min="0" step="0.01" required="" disabled="" value="$<?php echo number_format($aux->getCosto(), 2) ?>">
									  	</div>
									</div>
									<div class="column">
									  	<label class="label">Modalidad de compra</label>
									  	<div class="control">
									  		<input type="text" class="input" disabled="" value="<?php echo $aux->getModo() ?>">
									  	</div>
									</div>
								</div>
								<div class="columns">
									<div class="column">
									  	<label class="label">Descripción</label>
									  	<div class="control">
									  		<textarea class="textarea" name="descripcion" required="" maxlength="65535" disabled=""><?php echo $aux->getDescripcion() ?></textarea>
									  	</div>
									</div>
								</div>
								<?php foreach ($aux->documentos() as $key => $documento) { ?>
								<div class="columns">
									<div class="column">
								  		<a href="<?php echo $documento->getUrl() ?>">Archivo <?php echo $key+1 ?></a>
									</div>
								</div>
								<?php } if($usuario->getRol() == "Conciliador" && $aux->getStatus() != "Aprovada") { ?>
								<div class="columns">
									<div class="column">
									  	<div class="control has-text-right">
									  		<form action="../Controller/InconformidadController.php" method="post" style="display: inline;">
									  			<input type="hidden" name="action" value="validate">
									  			<input type="hidden" name="id" value="<?php echo $aux->getId() ?>">
										  		<button class="button is-success" type="submit">
										  			<p><i class="fa fa-check"></i> Aprovar</p>
										  		</button>
									  		</form>
									  		<form action="../Controller/InconformidadController.php" method="post" style="display: inline;">
									  			<input type="hidden" name="action" value="reject">
									  			<input type="hidden" name="id" value="<?php echo $aux->getId() ?>">
										  		<button class="button is-danger" type="submit">
										  			<p><i class="fa fa-times"></i> Anular</p>
										  		</button>
										  	</form>
									  	</div>
									</div>
								</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>