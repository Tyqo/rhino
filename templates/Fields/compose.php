<h1><?= $title ?> Field <i><?= $entry->name ?></i> in Table: <i><?= $tableName ?></i></h1>

<?= $this->Form->create($entry, ["class" => "stack"]); ?>

<div class="media-object">
	<div class="stack">
		<div class="stack--200">
			<?= $this->Form->control('type', ["type" => "select", "options" => $types, "required", 'value' => $entry->Type]); ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control("name", ["required"]) ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control("alias") ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control('description', ["type" => "textarea"]); ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control("position", ["value" => $entry->position ?: 0]) ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control("active", ["value" => $entry->active ?: 1]) ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control('null', ["type" => "checkbox", 'checked' => true]); ?>
		</div>
	</div>
	<div id="options" class="stack">
		<?= $settings ?>
	</div>
</div>

<div class="cluster">
	<?= $this->Form->button('Save') ?>
	<?= $this->Html->link("Back", ['action' => 'index', $tableName], ["class" => "button"]) ?>
</div>

<?= $this->Form->hidden('currentName', ["value" => $entry["name"]]) ?>
<?= $this->Form->hidden('tableName', ["value" => $tableName]) ?>
<?= $this->Form->hidden('id') ?>
<?= $this->Form->end(); ?>

<script>
	const type = document.getElementById('type');
	const options = document.getElementById('options');
	const table = document.querySelector('[name="tableName"]').value;
	const name = document.querySelector('[name="name"]').value;
	type.addEventListener('change', () => setOptions());

	function setOptions() {
		geOptions("/tusk/fields/get_options/" + table + "/" + type.value + "/" + name, options);
	}

	async function geOptions(url, element) {
		let response = await fetch(url);
		let options = await response.text();
		element.innerHTML = options;
		return options;
	}
</script>