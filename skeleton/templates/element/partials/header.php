<?php $rootId = 2 ?>

<header class="main-header box">
	<div class="outer-bound">

		<a id="home" href="/">
			<div class="logo">
				<!-- $this->parse(PATHTOWEBROOT . 'dist/img/logo.svg') ?> -->
				<span>Rhino</span>
			</div>
			<span class="sr-only">cmt_title</span>
		</a>

		<button id="menu-button" class="button nav--menu" aria-expanded="false">
			<div class="bars">
				<!-- $this->parse(PATHTOWEBROOT . 'dist/icons/bars.svg') ?> -->
			</div>

			<div class="cross">
				<!-- $this->parse(PATHTOWEBROOT . 'dist/icons/cross.svg') ?> -->
			</div>
		</button>

		<!-- $this->parsePHP(PATHTOWEBROOT . 'templates/shapes/components/nav.php', [
			'navId' => 'main-nav',
			'parentId' => $rootId
		]); ?> -->
	</div>
</header>