<div class="pages">
	<h1 class="caption">Pages</h1>

	<ul class="page-list">
		<?= $this->element('Pages/page_item', [
			'pages' => $pages
		]) ?>
	</ul>

	<?php
		if (in_array('add', $rights)) {
			$newButton = $this->svg("Tusk.plus") . '<span>' . __('New Page') . '</span>';
			echo $this->Html->link($newButton, ['action' => 'change'], ['escape' => false, 'class' => 'button icon-button']);
		} 
	?>
</div>