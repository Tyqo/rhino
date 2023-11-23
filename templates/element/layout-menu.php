<div class="layout-menu">
	<div class="cluster">
		<?= $this->Html->link('Back', [
				'action' => 'index'
			], [
				'class' => 'layout-menu__button'
			]) ?>
		
		<p>Editing: <?= $this->Layout->pageLink($page['id'], ['target' => '_blank']) ?></p>

		<?= $this->Form->button('New', [
			'id' => 'new-content', 
			'class' => 'layout-menu__button',
			'data-url' => $this->Url->build([
				'controller' => 'Contents',
				'action' => 'new',
				$page['id']])
			]) ?>
	</div>
</div>