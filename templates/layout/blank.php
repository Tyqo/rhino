<!doctype html>
<html class="no-js" lang="<?= $local ?>" data-theme="light">

<head>
	<?= $this->element('../layout/partials/head') ?>
</head>

<body>
	<a href="#main" class="button skip-link">Navigation Überspringen</a>

	<!-- Main Content -->
	<main id="main" class="main-content">
		<?= $this->fetch('content') ?>
		
		<div id="flash-messages" class="flash-messages">
			<?= $this->Flash->render() ?>
		</div>
	</main>
</body>

</html>