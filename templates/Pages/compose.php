<section class="inner-bound">
	<h1>
		<?= __(ucfirst($action)) ?> Page
	</h1>

	<?= $this->Form->create($entry, ["class" => "stack"]) ?>
	<fieldset>
		<?= $this->Rhino->sectionHeader("General Settings") ?>
		<?= $this->Rhino->control('name', ["required"]); ?>
		<?= $this->Rhino->control('active', ['role' => 'switch']); ?>
		<?= $this->Rhino->control('parent_id', ['options' => $pages, 'escape' => false]); ?>
		<?= $this->Rhino->control('role', ['options' => $roles]); ?>
		<?= $this->Rhino->control('template_id', ['options' => $templates]); ?>
	</fieldset>

	<div class="cluster pill">
		<?= $this->Form->button(__('Save')); ?>
		<?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'button contrast']); ?>
	</div>

	<?= $this->Form->end(); ?>
</section>