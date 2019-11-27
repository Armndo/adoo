<?php
	include_once("../Model/Usuario.php");
	include_once("../Model/Persona.php");

	session_start();
	if(!isset($_SESSION["usuario"]))
		header("Location: /proj");

	$usuario = $_SESSION["usuario"];
	
	if($usuario->getRol() != "Administrador")
		header("Location: /proj");

	$_GET["title"] = "Conciliadores";
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
								  			<?php foreach(Persona::Conciliadores() as $conciliador) { ?>
							  				<tr>
							  					<td><?php echo $conciliador->getId() ?></td>
							  					<td><?php echo $conciliador->getCurp() ?></td>
							  					<td><?php echo $conciliador->getNombre() . " " . $conciliador->getAppaterno() ?></td>
							  					<td><?php echo $conciliador->usuario()->getEmail() ?></td>
							  					<td class="has-text-centered">
							  						<a class="button is-link is-small" href="view.php?id=<?php echo $conciliador->getId() ?>"><p><i class="far fa-eye"></i> Ver</p></a>
							  						<a class="button is-warning is-small" href="edit.php?id=<?php echo $conciliador->getId() ?>"><p><i class="fas fa-pencil-alt"></i> Editar</p></a>
													<form action="../Controller/ConciliadorController.php" method="post" style="display: inline;">
														<input type="hidden" name="action" value="destroy">
														<input type="hidden" name="id" value="<?php echo $conciliador->getId() ?>">
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