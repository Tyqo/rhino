<section class="stack">
	<h1><?= $title ?> Field <code><?= $entry->name ?></code> in Table <code><?= $tableName ?></code></h1>

	<?= $this->Form->create($entry, ["class" => "stack"]); ?>

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
			<?= $this->Form->control('type', [
				"type" => "select",
				"options" => $typeOptions,
				"required",
				'value' => $entry->Type
			]); ?>
		</div>
	</div>

	<fieldset id="field-options">
		<?php foreach ($types as $type) : ?>
			<div id="<?= $type['name'] ?>-options">
				<?= $this->element("FieldOptions/" . $type['name']) ?>
			</div>
		<?php endforeach ?>
	</fieldset>

	<?= $this->Rhino->sectionHeader("Field Description") ?>
	<?= $this->Rhino->control('description', ["type" => "textarea", "description" => "Field Description. (optional)"]) ?>

	<div class="cluster">
        <?= $this->Form->button(__('Save Entry'), ['name' => 'save', 'type' => 'button']); ?>
        <?= $this->Form->button(__('Save & Exit')); ?>
		<?= $this->Html->link("Back", ['action' => 'index', $tableName], ["class" => "button"]) ?>
	</div>

	<?= $this->Form->hidden('currentName', ["value" => $entry["name"]]) ?>
	<?= $this->Form->hidden('table_name', ["value" => $tableName]) ?>
	<?= $this->Form->hidden('id') ?>
	<?= $this->Form->end(); ?>
</section>

<div hidden id="benched-options">
</div>
