<div>
	<?= $this->Rhino->sectionHeader("Select Settings") ?>

	<div>
		<?= $this->Rhino->control("default", [
			"value" => $entry->standard,
			'description' => "Standard value to use in a new Entry."
		]) ?>
	</div>

	<div>
		<?= $this->Rhino->control("Allow Empty", [
			"checked" => !empty($entry->options['selectEmpty']),
			'name' => 'settings[selectEmpty]',
			'type' => 'checkbox',
			'description' => "Allow empty values."
		]) ?>
	</div>

	<div>
		<?= $this->Rhino->control("Multi Select", [
			"checked" => !empty($entry->options['selectMultiple']),
			'name' => 'settings[selectMultiple]',
			'type' => 'checkbox',
			'description' => "Allow multiple Options."
		]) ?>
	</div>

	<div>
		<?= $this->Rhino->control("Separator", [
			"checked" => !empty($entry->options['selectSeparator']),
			'name' => 'settings[selectSeparator]',
			'value' => ',',
			'maxlength' => 1,
			'type' => 'text',
			'description' => "Separator to use in Data, use ',' for SQL operations."
		]) ?>
	</div>

	<?php $this->start('simpleSelect'); ?>
	<div class="grid">
		<?= $this->Rhino->control("selectKeys", [
			"value" => $entry->options['selectKeys'] ?? '',
			"name" => "settings[selectKeys]",
			"type" => "textarea",
			'description' => "List of possible Autosuggestions."
		]) ?>
		<?= $this->Rhino->control("selectValues", [
			"value" => $entry->options['selectValues'] ?? '',
			"name" => "settings[selectValues]",
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
		'Simple Select' => 'simpleSelect',
		'Select from DataTable' => 'fromDataTable',
	]); ?>
</div>