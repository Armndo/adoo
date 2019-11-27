<?php
	session_start();
	if(isset($_SESSION["usuario"]))
		header("Location: home.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<link rel="stylesheet" type="text/css" href="css/bulma.css">
		<link rel="stylesheet" type="text/css" href="css/all.css">
	</head>
	<body>
		<nav class="navbar" role="navigation" aria-label="main navigation">
			<div class="navbar-brand">
				<p class="title navbar-item">
					Conciliación en línea
				</p>
			</div>
		</nav>
		<div class="container" style="margin-top: 2em;">
			<div class="columns is-centered">
				<div class="column is-half">
					<div class="card">
						<div class="card-header">
						    <p class="card-header-title title is-4">
						      	Iniciar Sesión
						    </p>
						</div>
						<div class="card-content">
							<div class="content">
								<form action="Controller/SessionController.php" method="post">
									<input type="hidden" name="action" value="login">
									<div class="field">
									  	<label class="label">Correo electrónico</label>
									  	<div class="control">
							    			<input class="input" name="email" type="text" required="">
									  	</div>
									</div>
									<div class="field">
									  	<label class="label">Contraseña</label>
									  	<div class="control">
							    			<input class="input" name="password" type="password" required="">
									  	</div>
									</div>
									<div class="field">
									  	<div class="control has-text-right">
								  			<p>¿No tienes cuenta? Regístrate <a href="registro.php">aquí</a>.</p>
											<button type="submit" class="button is-success">
												<p><i class="fas fa-sign-in-alt"></i> Iniciar Sesión</p>
											</button>
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