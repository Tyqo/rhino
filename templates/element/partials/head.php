	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?= $this->getPageTitle() ?> | <?= WEBNAME ?></title>

	<script type="module">
		document.documentElement.classList.remove('no-js');
		document.documentElement.classList.add('js');
	</script>

	<link rel="stylesheet" href="/dist/css/main.css?v=<?= CMT_RUNTIME_ENVIRONMENT != 'production' ? $_SERVER['REQUEST_TIME'] : 1 ?>" as="style" />
	<link rel="stylesheet" href="/dist/css/webfonts.css" as="style" />
	<link rel="stylesheet" href="/dist/css/vendor/splide.min.css" />

	<meta name="description" content='<?= $this->getPageDescription() ?>'>
	<meta name="keywords" content='<?= $this->getPageImage() ?>'>

	<meta name="author" content="HALMA GmbH &amp; Co. KG Agentur für Werbung, https://www.agentur-halma.de">

	<meta property="og:title" content='<?= $this->getPageTitle() . "-" . WEBNAME ?>'>
	<meta property="og:description" content='<?= $this->getPageDescription() ?>'>
	<meta property="og:image" content='<?= $this->getPageImage() ?>'>

	<meta property="og:locale" content="<?= PAGELANG ?>">
	<meta property="og:type" content="website">
	<meta name="twitter:card" content="summary_large_image">
	<meta property="og:url" content="<?= URL ?>">

	<link rel="canonical" href="<?= URL ?>">
	<link rel="shortcut icon" href="/dist/img/favicons/favicon.ico" />
	<link rel="shortcut icon" href="/dist/img/logo.svg" />

	<meta name="theme-color" content="#ffffff">

	<!-- Schema.org JSON+LD -->
	<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "WebSite",
			"name": "<?= WEBNAME ?>",
			"url": "<?= URL ?>"
		}
	</script>
	<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "",
			"name": "",
			"legalName": "",
			"url": "<?= URL ?>",
			"email": "",
			"telephone": "",
			"address": {
				"@type": "PostalAddress",
				"addressLocality": "",
				"postalCode": "",
				"streetAddress": ""
			}
		}
	</script>

	<!-- Fail save for when JS is not working -->
	<?php if (!$this->isLayoutmode()) : ?>
		<script>
			window.onload = function() {
				setTimeout(() => {
					document.body.classList.add('page-has-loaded');
				}, 3000);
			}
		</script>
	<?php endif ?>

	<?= $this->layoutmodeHead() ?>