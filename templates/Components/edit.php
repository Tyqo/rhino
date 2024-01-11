<?= $this->Form->create($entry, ["class" => "modal-form"]); ?>
<?= $this->Form->control('element_id'); ?>

<div id="elements-container" data-request="<?= '/rhino/components/element/' . $entry->id // $this->Url->build(['action' => 'element']) ?>"></div>

<?= $this->Form->button(__('Save'), ['class' => 'rhino-button']); ?>
<?= $this->Form->hidden('html'); ?>

<?= $this->Form->end(); ?>