<?= $this->Rhino->sectionHeader("Float Settings") ?>

<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'description' => "Standard value to use in a new Entry."
	]) ?>

	<?= $this->Rhino->control("decimals", [
		"value" => $entry->options['decimals'] ?? '',
		"name" => "settings[decimals]",
		"type" => "number",
		'description' => "The amount of decimals to use."
	]) ?>
</div>