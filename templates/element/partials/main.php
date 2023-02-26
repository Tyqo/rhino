<div id="flash-messages" class="flash-messages">
	<?php foreach ($this->getFlashMessages() as $flashMessage) : ?>
		<?= $this->parsePHP(PATHTOWEBROOT . 'templates/shapes/components/info-message.php', [
			'type' => $flashMessage['type'],
			'title' => $flashMessage['title'],
			'message' => $flashMessage['message'],
		]) ?>
	<?php endforeach ?>
</div>

<main id="main" class="main-content <?php if ($this->isLayoutmode()) echo 'outer-bound' ?>">
	<?= $this->getPageContent(1) ?>

	<!-- Dummy Element for appling margin to -->
	<hr class="footer-margin" />
</main>

<div id="overlay" class="overlay">
	<?= $this->parsePHP(PATHTOWEBROOT . 'templates/shapes/components/light-box.php') ?>
</div>