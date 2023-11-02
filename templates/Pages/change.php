<section class="inner-bound">
	<?= $this->Form->create($entry, ["class" => "stack"]) ?>

	<?= $this->Form->control('name'); ?>
	<?= $this->Form->control('active'); ?>
	<?= $this->Form->control('is_homepage'); ?>
	<?= $this->Form->control('page_type', ['options' => $pageTypes]); ?>
	<?= $this->Form->control('url'); ?>
	<?= $this->Form->control('parent_id', ['options' => $pages, 'escape' => false]); ?>
	<?= $this->Form->control('layout_id', ['options' => $layouts]); ?>

	<div class="grid">
		<?= $this->Form->button(__('Save')); ?>
		<?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'button contrast']); ?>
	</div>

	<?= $this->Form->end(); ?>
</section>