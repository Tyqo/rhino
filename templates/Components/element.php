
<div id="<?= 'element-' . $component['id'] ?>" class="layout-element" draggable="false" data-position="<?= $component['position'] ?>" data-id="<?= $component['id'] ?>">

	<div class="element-container">
		<?= $this->element($component['template']['element'], array_merge($component->toArray(), ['layoutmode' => true])) ?>
	</div>

	<div class="layout-handle">
		<div class="layout-handle__actions">
			<?= $this->Form->button("menu", [
				'name' => 'move', 
				'class' => 'rhino-button icon',
				'escapeTitle' => false,
				'title' => __("Move Content"),
			]) ?>
			
			<?= $this->Form->select('template_id', $templates, [
				'class' => 'rhino-select',
				'value' => $component['template_id'],
				'data-url' => $this->Url->build([
					'controller' => 'Components',
					'action' => 'read',
					$component['id']
				])
			]); ?>
		</div>

		<div class="layout-handle__actions">
			<?= $this->Form->button('Active', [
				'name' => 'toggle', 
				'class' => 'rhino-button',
				'data-url' => $this->Url->build([
					'controller' => 'Components',
					'action' => 'update',
					$component['id']
				])
			]) ?>

			<?= $this->Form->button('Save', [
				'name' => 'save', 
				'class' => 'rhino-button',
				'data-url' => $this->Url->build([
					'controller' => 'Components',
					'action' => 'update',
					$component['id']
				])
			]) ?>

			<?= $this->Form->button('Delete', [
				'name' => 'delete', 
				'class' => 'rhino-button',
				'data-url' => $this->Url->build([
					'controller' => 'Components',
					'action' => 'delete',
					$component['id']
				])
			]) ?>
		</div>
	</div>
</div>


<?php // $this->element($entry['element']['elementName'], array_merge($entry->toArray(), ['layoutmode' => $layoutmode])); ?>
