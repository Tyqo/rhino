<?= $this->Rhino->sectionHeader("Integer Settings") ?>

<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		"type" => "number",
		"pattern" => '[0-9]*',
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>