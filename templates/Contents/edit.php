<?= $this->Form->create($entry, ["class" => "modal-form"]); ?>
<?= $this->Form->control('element_id'); ?>

<div id="editor" class="editor"></div>

<?= $this->Form->button(__('Save'), ['class' => 'tusk-button']); ?>
<?= $this->Form->hidden('html'); ?>

<?= $this->Form->end(); ?>