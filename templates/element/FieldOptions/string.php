<?= $this->Rhino->sectionHeader("String Settings") ?>
<?php $this->start('settings'); ?>
<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>
<?php $this->end('settings'); ?>

<?php $this->start('autosuggest'); ?>
<div>
	<?= $this->Rhino->control("SelectionList", [
		"value" => $entry->options['autosuggest'] ?? '',
		"name" => "settings[autosuggest]",
		"type" => "textarea",
		'description' => "List of possible Autosuggestions."
	]) ?>
</div>
<?php $this->end('autosuggest'); ?>

<?= $this->Rhino->getTab([
	'Settings' => 'settings',
	'Autosuggest' => 'autosuggest',
]); ?>