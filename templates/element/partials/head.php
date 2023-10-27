	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Tusk | <?= h($this->fetch('title')) ?> </title>

	<script type="module">
		document.documentElement.classList.remove('no-js');
		document.documentElement.classList.add('js');
	</script>

	<meta name="author" content="carsten.coull@swu.de">

	<?= $this->Html->meta(
		'/tusk/favicons/favicon.ico',
		'/tusk/favicons/favicon.ico',
		['type' => 'icon']
	); ?>

	<!-- To do: add Version Number to css -->
	<?= $this->Html->css(['Tusk.webfonts', 'Tusk.pico', 'Tusk.' . (isset($user) ? $user->theme : 'tusk')]) ?>
	<!--  $this->Html->css(['Tusk.webfonts', 'Tusk.main', 'Tusk.vendor/pico.min']) ?> -->

	<!-- Load main javascript -->
	<?= $this->Html->script(['Tusk.main'], ["type" => "module"]) ?>

	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>

	<!-- To do: check for OG support -->
	<!-- og:title, og:description, og:image, og:locale, og:type, og:url -->

	<meta name="theme-color" content="#ffffff">

	<!-- Schema.org JSON+LD -->
	<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "WebSite",
			"name": "WEBNAME",
			"url": "URL"
		}
	</script>
	<script type="application/ld+json">
		{
			"@context": "http://schema.org/",
			"@type": "",
			"name": "",
			"legalName": "",
			"url": "URL",
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
	<script>
		window.onload = function() {
			setTimeout(() => {
				document.body.classList.add('page-has-loaded');
			}, 3000);
		}
	</script>