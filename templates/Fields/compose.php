<section>
	<h1><?= $title ?> Field <i><?= $entry->name ?></i> in Table: <i><?= $tableName ?></i></h1>

	<?= $this->Form->create($entry, ["class" => "stack"]); ?>
</section>

<section>
	<div class="stack">
		<div class="grid">
			<div class="stack--200">
				<?= $this->Form->control("name", ["required"]) ?>
			</div>
			<div class="stack--200">
				<?= $this->Form->control("alias") ?>
			</div>
		</div>

		<div class="stack--200">
			<?= $this->Form->control('type', ["type" => "select", "options" => $types, "required", 'value' => $entry->Type]); ?>
		</div>
	</div>
</section>

<section>
	<?php $this->start('settings'); ?>
	<div class="stack--200">
		<?= $this->Rhino->control("default", [
			"value" => $entry->standard,
			'description' => "Standard value to use in a new Entry."
		]) ?>
	</div>
	<?php $this->end('settings'); ?>

	<?php $this->start('autosuggest'); ?>
	<div class="stack--200">
		<?= $this->Rhino->control("SelectionList", [
			"type" => "textarea",
			'description' => "List of possible Autosuggestions."
		]) ?>
	</div>
	<?php $this->end('autosuggest'); ?>

	<?= $this->Rhino->getTab([
		'Settings' => 'settings',
		'Autosuggest' => 'autosuggest',
	]); ?>
</section>

<section>
	<?= $this->Rhino->sectionHeader("Field Description") ?>
	<?= $this->Rhino->control('description', ["type" => "textarea", "description" => "Field Description. (optional)"]) ?>
</section>

<section>
	<div class="cluster">
		<?= $this->Form->button('Save') ?>
		<?= $this->Html->link("Back", ['action' => 'index', $tableName], ["class" => "button"]) ?>
	</div>

	<?= $this->Form->hidden('currentName', ["value" => $entry["name"]]) ?>
	<?= $this->Form->hidden('tableName', ["value" => $tableName]) ?>
	<?= $this->Form->hidden('id') ?>
	<?= $this->Form->end(); ?>
</section>