<menu id="main-menu" class="menu">
	<header>
		<div class="logo">
			<?= $this->svg("Rhino." . $user->theme . "-big") ?>
		</div>
		<span class="sr-only">Rhino</span>
	</header>

	<nav class="menu-nav">
		<?= $this->cell('Rhino.Groups'); ?>
	</nav>

	<!-- <footer>
	</footer> -->
</menu>