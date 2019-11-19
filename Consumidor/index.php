<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Consumidor.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];
	
	if($usuario->getRol() != "Administrador")
		header("Location: /proj");

	$_GET["title"] = "Consumidores";
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
								  				<th>CURP</th>
								  				<th>Nombre</th>
								  				<th>Correo Electrónico</th>
								  				<th>Acción</th>
								  			</tr>
								  		</thead>
								  		<tbody>
								  			<?php foreach(Consumidor::get() as $consumidor) { ?>
							  				<tr>
							  					<td><?php echo $consumidor->getId() ?></td>
							  					<td><?php echo $consumidor->getCurp() ?></td>
							  					<td><?php echo $consumidor->getNombre() . " " . $consumidor->getAppaterno() ?></td>
							  					<td><?php echo $consumidor->usuario()->getEmail() ?></td>
							  					<td class="has-text-centered">
							  						<a class="button is-link is-small" href="view.php?id=<?php echo $consumidor->getId() ?>"><p><i class="far fa-eye"></i> Ver</p></a>
							  						<a class="button is-warning is-small" href="edit.php?id=<?php echo $consumidor->getId() ?>"><p><i class="fas fa-pencil-alt"></i> Editar</p></a>
													<form action="../Controller/ConsumidorController.php" method="post" style="display: inline;">
														<input type="hidden" name="action" value="destroy">
														<input type="hidden" name="id" value="<?php echo $consumidor->getId() ?>">
							  							<button type="submit" class="button is-danger is-small"><p><i class="fas fa-times"></i> Eliminar</p></button>
						  							</form>
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