<!doctype html>
<html class="no-js" lang="<?= $local ?>" data-theme="light">

<head>
	<?= $this->element('../layout/partials/head') ?>
</head>

<?= $this->fetch('Rhino') ?>

<body>
	<a href="#main" class="button skip-link">Navigation Überspringen</a>

	<!-- Main header -->
	<?= $this->element('../layout/partials/header') ?>

	<!-- Main Content -->
	<main id="main" class="main-content">
		<div id="flash-messages" class="flash-messages">
			<?= $this->Flash->render() ?>
		</div>

		<?= $this->fetch('content') ?>
	</main>

	<!-- Main footer -->
	<?= $this->element('../layout/partials/footer') ?>

	<!-- To do: add Loading screen -->
</body>

</html>