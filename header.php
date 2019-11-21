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
						<a class="navbar-item" href="/proj/Inconformidad">
							<p><i class="fas fa-list-ul"></i> Lista</p>
						</a>
						<a class="navbar-item" href="/proj/Inconformidad/create.php">
							<p><i class="fas fa-plus"></i> Generar</p>
						</a>
					</div>
				</div>
				<?php } else if($usuario->getRol() == "Proveedor" || $usuario->getRol() == "Conciliador") { ?>
				<a class="navbar-item" href="/proj/Inconformidad">
					<p><i class="far fa-file"></i> Inconformidades</p>
				</a>
				<?php } if($usuario->getRol() != "Administrador") {?>
				<?php if($usuario->getRol() == "Conciliador") {?>
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						<p><i class="fas fa-headset"></i> Audiencias</p>
					</a>
					<div class="navbar-dropdown">
						<a class="navbar-item" href="/proj/Audiencia">
							<p><i class="fas fa-list-ul"></i> Lista</p>
						</a>
						<a class="navbar-item" href="/proj/Audiencia/create.php">
							<p><i class="fas fa-plus"></i> Generar</p>
						</a>
					</div>
				</div>
				<?php } else { ?>
				<a class="navbar-item" href="/proj/Audiencia">
					<p><i class="fas fa-headset"></i> Audiencias</p>
				</a>
				<?php } ?>
				<a class="navbar-item" href="/proj/<?php echo $usuario->getRol() ?>/view.php">
					<p>
						<?php
							$lel = "";
							switch($usuario->getRol()) {
								case 'Consumidor':
									$lel = "user";
									break;
								case 'Proveedor':
									$lel = "truck";
									break;
								case 'Conciliador':
									$lel = "user-tie";
									break;
								default:
									$lel = "user";
									break;
					  		}
						?>
						 <i class="fas fa-<?php echo $lel ?>"></i> Perfil
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
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						<p><i class="fas fa-truck"></i> Proveedores</p>
					</a>
					<div class="navbar-dropdown">
						<a class="navbar-item" href="/proj/Proveedor">
							<p><i class="fas fa-list-ul"></i> Lista</p>
						</a>
						<a class="navbar-item" href="/proj/Proveedor/create.php">
							<p><i class="fas fa-plus"></i> Registrar</p>
						</a>
					</div>
				</div>
				<div class="navbar-item has-dropdown is-hoverable">
					<a class="navbar-link">
						<p><i class="fas fa-user-tie"></i> Conciliadores</p>
					</a>
					<div class="navbar-dropdown">
						<a class="navbar-item" href="/proj/Conciliador">
							<p><i class="fas fa-list-ul"></i> Lista</p>
						</a>
						<a class="navbar-item" href="/proj/Conciliador/create.php">
							<p><i class="fas fa-plus"></i> Registrar</p>
						</a>
					</div>
				</div>
				<?php } ?>
			</div>
		</div>
	</nav>
</div>