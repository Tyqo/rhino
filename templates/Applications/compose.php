<section>
	<?php if ($action == "edit") : ?>
		<h1>Edit Table: <i><?= $tableName ?></i></h1>
	<?php else : ?>
		<h1>Create new Table</i></h1>
	<?php endif ?>

	<?= $this->Form->create($entry, ["class" => "stack"]); ?>
	<?= $this->Form->control('name') ?>
	<?= $this->Form->control('alias') ?>

	<?= $this->Form->control('rhino_group_id', [
		"type" => "select",
		"options" => $groups
	]); ?>

	<?= $this->Form->control('active', ["type" => "checkbox"]) ?>

	<?php if (isset($appFields)) : ?>
		<?= $this->Rhino->control('overview_fields', [
			'label' => 'Overview Fields',
			"type" => "select",
			"options" => $appFields,
			"multiple" => true,
			'value' => $entry->overviewData

		]) ?>
	<?php endif ?>

	<?= $this->Form->hidden('currentName', ["value" => isset($tableName) ? $tableName : '']) ?>
	<?= $this->Form->hidden('id') ?>

	<div class="cluster">
		<?= $this->Form->button('Save') ?>
		<?= $this->Html->link("Back", ['action' => 'index'], ["class" => "button"]) ?>
	</div>

	<?= $this->Form->end(); ?>
</section>
