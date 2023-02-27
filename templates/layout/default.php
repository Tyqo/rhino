<!doctype html>
<html class="no-js" lang="<?= $local ?>">
<head>
	<?= $this->element('partials/head') ?>
</head>

<body>
	<a href="#main" class="skip-link button">common.skip-navigation</a>

	<!-- Main header -->
	<?= $this->element('partials/header') ?>

	<!-- Main Content -->
	<?= $this->element('partials/main') ?>

	<!-- Main footer -->
	<?= $this->element('partials/footer') ?>

	<!-- To do: add Loading screen -->
</body>
</html>