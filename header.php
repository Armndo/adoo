<div class="card-header">
	<nav class="navbar" role="navigation" aria-label="main navigation">
		<div class="navbar-brand">
			<h1 class="title navbar-item">
				<?php echo $_GET["title"]; ?>
			</h1>
		</div>
		<div id="navbarBasicExample" class="navbar-menu">
			<div class="navbar-start">
				<?php if($usuario->getRol() == "Consumidor") { ?>
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						<p><i class="far fa-file"></i> Inconformidades</p>
					</a>
					<div class="navbar-dropdown">
						<a class="navbar-item" href="/proj/Inconformidades">
							<p><i class="fas fa-list-ul"></i> Lista</p>
						</a>
						<a class="navbar-item" href="/proj/Inconformidades/create.php">
							<p><i class="fas fa-plus"></i> Crear</p>
						</a>
					</div>
				</div>
				<?php } else if($usuario->getRol() == "Proveedor" || $usuario->getRol() == "Conciliador") { ?>
				<a class="navbar-item" href="/proj/Inconformidades">
					<p><i class="far fa-file"></i> Inconformidades</p>
				</a>
				<?php } if($usuario->getRol() != "Administrador") {?>
				<a class="navbar-item" href="/proj/Audiencias">
					<p><i class="fas fa-headset"></i> Audiencias</p>
				</a>
				<a class="navbar-item" href="/proj/Consumidor/view.php">
					<p>
						<?php
							switch($usuario->getRol()) {
								case 'Consumidor':
									echo '<i class="fas fa-user"></i>';
									break;
								case 'Proveedor':
									echo '<i class="fas fa-truck"></i>';
									break;
								case 'Conciliador':
									echo '<i class="fas fa-user-tie"></i>';
									break;
								default:
									echo '<i class="fas fa-user"></i>';
									break;
					  		}
						?>
						 Perfil
					</p>
				</a>
				<?php } if($usuario->getRol() == "Administrador") { ?>
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						<p><i class="fas fa-users"></i> Consumidores</p>
					</a>
					<div class="navbar-dropdown">
						<a class="navbar-item" href="/proj/Consumidor">
							<p><i class="fas fa-list-ul"></i> Lista</p>
						</a>
						<a class="navbar-item" href="/proj/Consumidor/create.php">
							<p><i class="fas fa-plus"></i> Registrar</p>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</nav>
</div>