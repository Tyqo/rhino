<?= $this->Rhino->sectionHeader("Float Settings") ?>

<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'type' => 'string',
		'string' => "0.01",
		"pattern" => '[0-9.,]*',
		'description' => "Standard value to use in a new Entry."
	]) ?>

	<?= $this->Rhino->control("decimals", [
		"value" => $entry->options['decimals'] ?? '',
		"name" => "settings[decimals]",
		"type" => "number",
		"pattern" => '[0-9]*',
		'description' => "The amount of decimals to use."
	]) ?>
</div>