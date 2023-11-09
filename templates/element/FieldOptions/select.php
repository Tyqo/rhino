<div>
	<?= $this->Rhino->sectionHeader("Select Settings") ?>

	<?php $this->start('settings'); ?>
	<div>
		<?= $this->Rhino->control("default", [
			"value" => $entry->standard,
			'description' => "Standard value to use in a new Entry."
		]) ?>
	</div>
	<?php $this->end('settings'); ?>

	<?php $this->start('simpleSelect'); ?>
	<div class="grid">
		<?= $this->Rhino->control("keys", [
			"value" => $entry->options['keys'] ?? '',
			"name" => "settings[keys]",
			"type" => "textarea",
			'description' => "List of possible Autosuggestions."
		]) ?>
		<?= $this->Rhino->control("values", [
			"value" => $entry->options['values'] ?? '',
			"name" => "settings[values]",
			"type" => "textarea",
			'description' => "List of possible Autosuggestions."
		]) ?>
	</div>
	<?php $this->end('simpleSelect'); ?>

	<?php $this->start('fromDataTable'); ?>
	<div>
		<?= $this->Rhino->control("Select from DataTable", [
			"value" => $entry->options['selectFromTable'] ?? '',
			"name" => "settings[selectFromTable]",
			"type" => "select",
			"options" => $tables
		]) ?>
		<?= $this->Rhino->control("selectFromValue", [
			"value" => $entry->options['selectFromValue'] ?? '',
			"name" => "settings[selectFromValue]"
		]) ?>
		<?= $this->Rhino->control("selectFromAlias", [
			"value" => $entry->options['selectFromAlias'] ?? '',
			"name" => "settings[selectFromAlias]"
		]) ?>
		<?= $this->Rhino->control("selectFromSQL", [
			"value" => $entry->options['selectFromSQL'] ?? '',
			"name" => "settings[selectFromSQL]"
		]) ?>
	</div>
	<?php $this->end('fromDataTable'); ?>

	<?= $this->Rhino->getTab([
		'Settings' => 'settings',
		'Simple Select' => 'simpleSelect',
		'Select from DataTable' => 'fromDataTable',
	]); ?>
</div>