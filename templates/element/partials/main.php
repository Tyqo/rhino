<div id="flash-messages" class="flash-messages">
	<?= $this->Flash->render() ?>
</div>

<main id="main" class="main-content">
	 <?= $this->fetch('content') ?>

	<!-- Dummy Element for appling margin to -->
	<hr class="footer-margin" />
</main>

<div id="overlay" class="overlay">
	<!-- $this->parsePHP(PATHTOWEBROOT . 'templates/shapes/components/light-box.php') ?> -->
</div>