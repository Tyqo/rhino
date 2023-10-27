<header class="main-header">
	<div class="outer-bound cluster">
		<h3><?= h($this->fetch('title')) ?></h3>
	</div>
	<button id="menu-button" class="icon-button button-reset">
		<span class="sr-only">Toggle menu</span>
		<span class="icon menu"><?= $this->svg('Rhno.menu') ?></span>
		<span class="icon cross"><?= $this->svg('Rhno.x') ?></span>
	</button>
</header>