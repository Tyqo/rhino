<!doctype html>
<html class="no-js" lang="<?= $local ?>"  data-theme="light">
<head>
	<?= $this->element('partials/head') ?>
</head>

<body class="<?= h($this->classSave($this->fetch('title'))) ?>">
	<a href="#main" class="skip-link button">common.skip-navigation</a>

	<?= $this->element('partials/frame') ?>

	<div id="overlay" class="overlay">
		<!-- $this->parsePHP(PATHTOWEBROOT . 'templates/shapes/components/light-box.php') ?> -->
	</div>
</body>
</html>
