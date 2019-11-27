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
	
	if($usuario->getRol() == "Administrador")
		header("Location: /proj");

	$aux = null;
	$audiencias = null;
	switch($usuario->getRol()) {
		case 'Consumidor':
			$aux = $usuario->persona();
			$audiencias = $aux->audiencias();
			break;
		case 'Conciliador':
			$aux = $usuario->persona();
			$audiencias = Audiencia::get();
			break;
		case 'Proveedor':
			$aux = $usuario->proveedor();
			$audiencias = $aux->audiencias();
			break;
		default:
			break;
	}
	$_GET["title"] = "Audiencias";
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
								<div class="table-container">
								  	<table class="table is-bordered is-striped is-hoverable is-fullwidth">
								  		<thead>
								  			<tr>
								  				<th>ID</th>
								  				<th>Fecha</th>
								  				<th>ID Inconformidad</th>
								  				<th>Consumidor</th>
								  				<th>Proveedor</th>
								  				<th>Conciliador</th>
								  				<th>Acción</th>
								  			</tr>
								  		</thead>
								  		<tbody>
								  			<?php foreach($audiencias as $audiencia) { ?>
								  			<?php $void = 0; ?>
							  				<tr>
							  					<td><?php echo $audiencia->getId() ?></td>
							  					<td><?php echo date("d/m/Y", strtotime($audiencia->getFecha())) . " " . date("h:i", strtotime($audiencia->getHora())) ?></td>
							  					<td><?php echo $audiencia->inconformidad()->getId() ?></td>
							  					<td><?php $cons = $audiencia->inconformidad()->consumidor(); echo $cons->getNombre() . " " . $cons->getAppaterno() ?></td>
							  					<td><?php $prov = $audiencia->inconformidad()->proveedor(); echo $prov->getRazon() ?></td>
							  					<td><?php $conc = $audiencia->conciliador(); echo $conc->getNombre() . " " . $conc->getAppaterno() ?></td>
							  					<td class="has-text-centered">
							  						<?php if($usuario->getRol() == "Conciliador") { ?>
							  						<a class="button is-link is-small" href="view.php?id=<?php echo $audiencia->getId() ?>"><p><i class="far fa-eye"></i> Ver</p></a>
							  						<a class="button is-warning is-small" href="edit.php?id=<?php echo $audiencia->getId() ?>"><p><i class="fas fa-pencil-alt"></i> Editar</p></a>
							  						<?php } else {
							  							$void = 1;
							  						}
							  							$hoy = strtotime(date("Y-m-d"));
							  							$fecha = strtotime($audiencia->getFecha());
							  							$ahora = strtotime(date("h:i:s"));
							  							$hora = strtotime(date($audiencia->getHora()));
							  							$en10 = $hora + 600;
							  							if($hoy == $fecha && $ahora >= $hora && $ahora <= $en10) {
					  								?>
						  							<a href="../Mensaje/?audiencia_id=<?php echo $audiencia->getId() ?>" class="button is-success is-small"><p><i class="fas fa-check"></i> Participar</p></a>
							  						<?php } elseif($void) { ?>
							  							<p>N/A</p>
						  							<?php } ?>
							  					</td>
							  				</tr>
								  			<?php } ?>
								  		</tbody>
								  	</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>