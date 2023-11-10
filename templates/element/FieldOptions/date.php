<?= $this->Rhino->sectionHeader("Date Settings") ?>

<div>
	<?php $this->start('settings'); ?>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'type' => 'date',
		'description' => "Standard value to use in a new Entry."
	]) ?>
	<?php $this->end('settings'); ?>

	<?php $this->start('automation'); ?>
	<?= $this->Rhino->control("current_time", [
		"checked" => $entry->standard == "current_timestamp()",
		"type" => "checkbox",
		'description' => "Use the Current Date as Default."
	]) ?>
	<?php $this->end('automation'); ?>

	<?= $this->Rhino->getTab([
		'Settings' => 'settings',
		'Automation' => 'automation',
	]); ?>
</div>