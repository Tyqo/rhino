<?= $this->Rhino->sectionHeader("DateTime Settings") ?>

<div>
	<?php $this->start('settings'); ?>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'type' => 'datetime',
		'description' => "Standard value to use in a new Entry."
	]) ?>
	<?php $this->end('settings'); ?>

	<?php $this->start('automation'); ?>
	<?= $this->Rhino->control("current_time", [
		"checked" => $entry->standard == "current_timestamp()",
		"type" => "checkbox",
		'description' => "Use the Current Date Time as Default."
	]) ?>

	<?= $this->Rhino->control("update_time", [
		"checked" => $entry->extra == "on update current_timestamp()",
		"type" => "checkbox",
		'description' => "Use the Current Date Time on Save."
	]) ?>
	<?php $this->end('automation'); ?>

	<?= $this->Rhino->getTab([
		'Settings' => 'settings',
		'Automation' => 'automation',
	]); ?>
</div>