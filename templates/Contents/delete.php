<?= $this->Form->create($entry, ["class" => "stack modal-form"]); ?>
<p>Do you want to delete the Element of type "<?= $entry['element']['element'] ?>"</p>
<?= $this->Form->button(__('delete'), ['class' => 'rhno-button']); ?>
<?= $this->Form->end(); ?>
