<div class="frame">
	<!-- Main Sidebar -->
	<nav id="main-nav" class="frame__sidebar">
		<?= $this->cell('Tusk.Groups'); ?>
	</nav>
	
	<!-- Main Content -->
	
	<div class="frame__content">
		<?= $this->element('partials/header') ?>

		<div id="flash-messages" class="flash-messages">
			<?= $this->Flash->render() ?>
		</div>
		
		<main id="main" class="main-content">
		
			<div class="outer-bound">
				<?= $this->fetch('content') ?>
			</div>

			<hr class="footer-margin" />
		</main>

		<?= $this->element('partials/footer') ?>
	</div>
	
</div>