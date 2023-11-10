<?= $this->Rhino->sectionHeader("Time Settings") ?>

<div>
	<?php $this->start('settings'); ?>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'type' => 'time',
		'description' => "Standard value to use in a new Entry."
	]) ?>
	<?php $this->end('settings'); ?>

	<?php $this->start('automation'); ?>
	<?= $this->Rhino->control("current_time", [
		"checked" => $entry->standard == "current_timestamp()",
		"type" => "checkbox",
		'description' => "Use the Current Time as Default."
	]) ?>
	<?php $this->end('automation'); ?>

	<?= $this->Rhino->getTab([
		'Settings' => 'settings',
		'Automation' => 'automation',
	]); ?>
</div>