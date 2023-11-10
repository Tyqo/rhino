<?= $this->Rhino->sectionHeader("Checkbox Settings") ?>

<div>
	<?= $this->Rhino->control("default", [
		"checked" => $entry->standard,
		'type' => 'checkbox',
		'description' => "Standard value to use in a new Entry."
	]) ?>

	<?= $this->Rhino->control("style", [
		"value" => $entry->options['checkboxStyle'] ?? '',
		"name" => "settings[checkboxStyle]",
		"type" => "select",
		'options' => [null => 'checkbox', 'switch' => 'switch'],
		'description' => "The style of the Checkbox."
	]) ?>
</div>