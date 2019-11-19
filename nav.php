<nav class="navbar" role="navigation" aria-label="main navigation">
	<!-- <div class="columns">
		<div class="colum"></div>
		<div class="colum"></div>
	</div> -->
	<div class="navbar-brand">
		<a class="title navbar-item" style="" href="/proj">
			Conciliación en línea
		</a>
	</div>
	<div class="navbar-end">
		<div class="navbar-item">
			<form action="/proj/Controller/SessionController.php" method="post">
				<input type="hidden" name="action" value="logout">
				<button type="submit" class="button is-danger">
					<p><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</p>
				</button>
			</form>
		</div>
	</div>
</nav>