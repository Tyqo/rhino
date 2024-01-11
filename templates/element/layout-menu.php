<div class="layout-menu">
	<div class="cluster">
		<?= $this->Html->link('Back', [
				'action' => 'index'
			], [
				'class' => 'layout-menu__button'
			]) ?>
		
		<p>Editing: <?= $this->Layout->pageLink($page['id'], ['target' => '_blank']) ?></p>
	</div>
</div>