
<div id="<?= 'element-' . $component->id ?>" class="layout-element" draggable="false" data-position="<?= $component->position ?>" data-id="<?= $component->id ?>">

	<div class="element-container">
		<?= $this->element($component->template->element, array_merge($component->toArray(), ['layoutmode' => true])) ?>
	</div>

	<div class="layout-handle">
		<div class="layout-handle__actions">
			<?php 
			// $this->Form->button("menu", [
			// 	'name' => 'move', 
			// 	'class' => 'rhino-button icon',
			// 	'escapeTitle' => false,
			// 	'title' => __("Move Content"),
			// ]) 
			?>
			
			<?= $this->Form->select('template_id', $templates, [
				'class' => 'rhino-select',
				'value' => $component['template_id']
			]); ?>
		</div>

		<div class="layout-handle__actions">
			<?= $this->Form->button($this->Icon->svg("Rhino.eye"), [
				'escapeTitle' => false,
				'title' => __("toggle Active"),
				'name' => 'toggle', 
				'class' => 'rhino-button'
			]) ?>

			<?= $this->Form->button($this->Icon->svg("Rhino.save"), [
				'escapeTitle' => false,
				'title' => __("Save"),
				'name' => 'save', 
				'class' => 'rhino-button'
			]) ?>

			<?= $this->Form->button($this->Icon->svg("Rhino.trash"), [
				'escapeTitle' => false,
				'title' => __("Delete"),
				'name' => 'delete', 
				'class' => 'rhino-button'
			]) ?>
		</div>
	</div>
</div>
