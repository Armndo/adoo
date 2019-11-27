<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");
	include_once("../Model/Proveedor.php");
	include_once("../Model/Inconformidad.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];
	
	if($usuario->getRol() == "Administrador")
		header("Location: /proj");

	$aux = null;
	switch($usuario->getRol()) {
		case 'Consumidor':
			$aux = $usuario->persona();
			break;
		case 'Conciliador':
			$aux = $usuario->persona();
			break;
		case 'Proveedor':
			$aux = $usuario->proveedor();
			break;
		default:
			break;
	}

	$_GET["title"] = "Inconformidades";
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
								  				<th>Lugar</th>
								  				<th style="width: 20%;">Proveedor</th>
								  				<th>Status</th>
								  				<th>Acción</th>
								  			</tr>
								  		</thead>
								  		<tbody>
								  			<?php foreach($aux->inconformidades() as $inconformidad) { ?>
							  				<tr>
							  					<td><?php echo $inconformidad->getId() ?></td>
							  					<td><?php echo date("d/m/Y", strtotime($inconformidad->getFecha())) ?></td>
							  					<td><?php echo $inconformidad->getEstado() ?></td>
							  					<td><?php echo $inconformidad->proveedor()->getRazon() ?></td>
							  					<td><?php echo $inconformidad->getStatus() ?></td>
							  					<td class="has-text-centered">
							  						<a class="button is-link is-small" href="view.php?id=<?php echo $inconformidad->getId() ?>"><p><i class="far fa-eye"></i> Ver</p></a>
													<?php if($inconformidad->getStatus() == "No Aprovada") { ?>
							  						<a class="button is-warning is-small" href="edit.php?id=<?php echo $inconformidad->getId() ?>"><p><i class="fas fa-pencil-alt"></i> Editar</p></a>
													<form action="../Controller/ConsumidorController.php" method="post" style="display: inline;">
														<input type="hidden" name="action" value="destroy">
							  							<button type="submit" class="button is-danger is-small"><p><i class="fas fa-times"></i> Eliminar</p></button>
														<input type="hidden" name="id" value="<?php echo $inconformidad->getId() ?>">
					  								</form>
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