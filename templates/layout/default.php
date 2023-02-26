<!doctype html>
<html class="no-js" lang="<?= $local ?>">
<head>
	<?= $this->parsePHP(PATHTOWEBROOT . 'templates/partials/head.php') ?>
</head>

<body class="<?php if ($this->getPageData()['cmt_isroot'] == 1 && PAGEID != 0) echo 'start' ?>">
	<a href="#main" class="skip-link button"><?= $this->I18N("common.skip-navigation") ?></a>

	<!-- Main header -->
	<?= $this->parsePHP(PATHTOWEBROOT . 'templates/partials/header.php') ?>

	<!-- Main Content -->
	<?= $this->parsePHP(PATHTOWEBROOT . 'templates/partials/main.php') ?>

	<!-- Main footer -->
	<?= $this->parsePHP(PATHTOWEBROOT . 'templates/partials/footer.php') ?>

	<!-- If it's ok for JS to be excuted in Javascript omit the {IF..} -->
	<?php if (!$this->isLayoutmode()) : ?>
		<!-- Load main javascript -->
		<script type="module" src="/dist/js/main.js?v=<?= CMT_RUNTIME_ENVIRONMENT != 'production' ? $_SERVER['REQUEST_TIME'] : 1 ?>"></script>
	<?php else : ?>
		<script>
			console.info("Layoutmode detected: Main Javascript not loaded");
		</script>
	<?php endif ?>

	<?= $this->parsePHP(PATHTOWEBROOT . 'templates/shapes/components/loading-screen.php') ?>

	<?= $this->layoutmodeMenu() ?>
</body>

</html>