<menu id="main-menu" class="menu">
	<header>
		<div class="logo">
			<?= $this->Icon->svg("Rhino." . $this->Identity->get('theme') . "-big") ?>
		</div>
		<span class="sr-only">Rhino</span>
	</header>

	<nav class="menu-nav">
		<?= $this->cell('Rhino.Groups'); ?>
	</nav>
</menu>