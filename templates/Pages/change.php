<?= $this->Form->create($entry, ["class" => "stack"]) ?>

<?= $this->Form->control('name'); ?>
<?= $this->Form->control('active'); ?>
<?= $this->Form->control('is_homepage'); ?>
<?= $this->Form->control('type'); ?>
<?= $this->Form->control('parent', ['options' => $pages]); ?>
<?= $this->Form->control('layout_id', ['options' => $layouts]); ?>

<div class="cluster">
	<?= $this->Form->button(__('Save')); ?>
	<?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'button']); ?>
</div>

<?= $this->Form->end(); ?>