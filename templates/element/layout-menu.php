<div class="layout-menu">
	<div class="cluster">
		<?= $this->Html->link('Back', [
				'action' => 'index'
			], [
				'class' => 'layout-menu__button'
			]) ?>
		
		<p>Editing: <?= $this->pageLink($page['id'], ['target' => '_blank']) ?></p>

		<button
				class="layout-menu__button open-modal"
				name="New Content"
				value="<?= $this->Url->build([
					'controller' => 'Contents',
					'action' => 'new', 
					$page['id']]) ?>"
				data-dispatch="updateContent"
				>
				New
			</button>
	</div>
</div>