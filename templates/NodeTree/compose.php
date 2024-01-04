<section class="inner-bound">
	<h1>
		<?= __(ucfirst($action)) ?> Page
	</h1>

	<?= $this->Form->create($nodeTree, ["class" => "stack"]) ?>
	<fieldset>
		<?= $this->Rhino->sectionHeader("General Settings") ?>
		<?= $this->Rhino->control('name', ["required"]); ?>
		<?= $this->Rhino->control('parent_id', ['options' => $nodes, 'escape' => false]); ?>
		<?= $this->Rhino->control('node_type', ['options' => $nodeTypes]); ?>
		<?= $this->Rhino->control('active', ['role' => 'switch']); ?>
		<?= $this->Rhino->control('role', ['options' => $roles]); ?>
	</fieldset>

	<fieldset>
		<?= $this->Rhino->sectionHeader("Type Settings") ?>
		<?php $this->start('page'); ?>
		<?= $this->Rhino->control('layout_id', ['options' => $layouts]); ?>
		<?php $this->end('settings'); ?>
		
		<?php $this->start('link'); ?>
		<?= $this->Rhino->control('url'); ?>
		<?php $this->end('settings'); ?>
		
		<?= $this->Rhino->getTab([
			'Page Settings' => 'page',
			'Link Settings' => 'link',
		]); ?>
	</fieldset>

	<div class="cluster pill">
		<?= $this->Form->button(__('Save')); ?>
		<?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'button contrast']); ?>
	</div>

	<?= $this->Form->end(); ?>
</section>