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
	$aud = new Audiencia();
	$aud->find($_GET["audiencia_id"]);
	$inc = $aud->inconformidad();

	if(($usuario->getRol() == "Consumidor" && $usuario->persona()->getId() != $inc->getConsumidor_id()) || ($usuario->getRol() == "Conciliador" && $usuario->persona()->getId() != $aud->getConciliador_id()) || ($usuario->getRol() == "Proveedor" && $usuario->proveedor()->getId() != $inc->getProveedor_id()))
		header("Location: ../Audiencia");

	$aux = null;
	$user = null;
	switch ($usuario->getRol()) {
		case 'Consumidor':
			$aux = $usuario->persona();
			$user = $aux->getNombre() . " " . $aux->getAppaterno();
			break;
		case 'Conciliador':
			$aux = $usuario->persona();
			$user = $aux->getNombre() . " " . $aux->getAppaterno();
			break;
		case 'Proveedor':
			$aux = $usuario->proveedor();
			$user = $aux->getRazon();
			break;
		default:
			break;
	}

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
								<form id="form">
									<input type="hidden" name="action" value="store">
									<input type="hidden" name="audiencia_id" value="<?php echo $_GET["audiencia_id"] ?>">
									<input type="hidden" name="user" value="<?php echo $user ?>">
									<div class="columns">
										<div class="column">
											<div id="chat" style="height: 300px; overflow-y: scroll;"></div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<div class="control">
												<textarea id="mensaje" class="textarea" name="mensaje" required=""></textarea>
										  	</div>
										</div>
									</div>
									<div class="columns">
										<div class="column">
										  	<div class="control has-text-right">
												<button class="button is-link" id="boton">Enviar</button>
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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<script type="text/javascript">
	
	$(document).ready(function() {
		registrarMensajes();
		setInterval("cargarMensajes()", 500);
	});

	function registrarMensajes() {
		$("#boton").click(function(e) {
			e.preventDefault();
			var form = $("#form").serialize();
			if($("#mensaje").val() != "") {
				$.ajax({
					type : "post",
					url : "../Controller/MensajeController.php",
					data : form
				}).done(function(res) {
					$("#mensaje").val("");
					$("#chat").scrollTop(0);
					console.log(res);
				});
			} else {
				alert("No envíes mensajes vacíos!");
			}
		});
	}

	function cargarMensajes() {
		$.ajax({
			type : "post",
			url : "../Controller/MensajeController.php",
			data : {
				action : "read",
				audiencia_id : "<?php echo $_GET['audiencia_id']?>"
			}
		}).done(function(res) {
			$("#chat").html(res);
			$("#chat p:first-child").addClass("has-text-primary");
		});
	}

</script>