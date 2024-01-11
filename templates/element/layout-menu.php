<div class="layout-menu">
	<?= $this->Html->link('Back', [
			'action' => 'index'
		], [
			'class' => 'layout-button'
		]) ?>
	
	<p>Editing: <?= $this->Layout->pageLink($page['id'], ['target' => '_blank']) ?></p>
</div>