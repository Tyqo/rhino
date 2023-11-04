<?= $this->Rhino->sectionHeader("Integer Settings") ?>

<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>