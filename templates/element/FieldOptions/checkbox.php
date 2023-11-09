<?= $this->Rhino->sectionHeader("Checkbox Settings") ?>

<div>
	<?= $this->Rhino->control("default", [
		"checked" => $entry->standard,
		'type' => 'checkbox',
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>