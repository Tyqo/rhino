<!doctype html>
<html class="no-js" lang="<?= $local ?>" data-theme="light">

<head>
	<?= $this->element('../layout/partials/head') ?>
</head>

<body <?= h($this->classSave($this->fetch('title'))) ?>">
	<a href="#main" class="button skip-link">Navigation Überspringen</a>

	<div class="menu-wrapper">
		<?= $this->element('../layout/partials/menu') ?>

		<div class=" menu-page">
			<!-- Main header -->
			<?= $this->element('../layout/partials/header') ?>

			<main id="main" class="main-content">
				<?= $this->fetch('content') ?>

				<div id="flash-messages" class="flash-messages">
					<?= $this->Flash->render() ?>
				</div>
			</main>

			<!-- Main footer -->
			<?= $this->element('../layout/partials/footer') ?>
		</div>
	</div>

</body>

</html>