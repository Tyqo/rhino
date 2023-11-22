
<div id="<?= 'element-' . $content['id'] ?>" class="layout-element" draggable="true" data-position="<?= $content['position'] ?>" data-id="<?= $content['id'] ?>">

	<div class="element-container">
		<?= $this->element($content['element']['elementName'], array_merge($content->toArray(), ['layoutmode' => true])) ?>
	</div>

	<div class="layout-handle">
		<div class="layout-handle__select">
			<?= $this->Form->select('element_id', $elements, [
				'class' => 'rhino-select',
				'value' => $content['element_id'],
				'data-url' => $this->Url->build([
					'controller' => 'Contents',
					'action' => 'read',
					$content['id']
				])
			]); ?>
		</div>

		<div class="layout-handle__actions">
			<?= $this->Form->button('Active', [
				'name' => 'toggle', 
				'class' => 'rhino-button',
				'data-url' => $this->Url->build([
					'controller' => 'Contents',
					'action' => 'update',
					$content['id']
				])
			]) ?>

			<?= $this->Form->button('Save', [
				'name' => 'save', 
				'class' => 'rhino-button',
				'data-url' => $this->Url->build([
					'controller' => 'Contents',
					'action' => 'update',
					$content['id']
				])
			]) ?>

			<?= $this->Form->button('Delete', [
				'name' => 'delete', 
				'class' => 'rhino-button',
				'data-url' => $this->Url->build([
					'controller' => 'Contents',
					'action' => 'delete',
					$content['id']
				])
			]) ?>
		</div>
	</div>
</div>


<?php // $this->element($entry['element']['elementName'], array_merge($entry->toArray(), ['layoutmode' => $layoutmode])); ?>
