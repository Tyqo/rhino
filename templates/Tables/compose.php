<?php
$options = [];

if (isset($readonly) && $readonly) {
	$options['readonly'] = true;
}
?>

<h1><?= $title ?></h1>

<?= $this->Form->create($entry, ["class" => "stack--300"]); ?>

<?php if ($action != 'add') : ?>
	<div class="cluster pill">
		<?= $this->Html->link("prev", ["controller" => "tables", "action" => $action, $tableName, $prevId], ["class" => "button", "disabled" => empty($prevId)]) ?>
		<?= $this->Html->link("next", ["controller" => "tables", "action" => $action, $tableName, $nextId], ["class" => "button", "disabled" => empty($nextId)]) ?>
	</div>
<?php endif ?>

<?= $this->Fields->render($fields, $entry, $options) ?>

<?php if ($entry->getVirtual() > 0) {
	foreach ($entry->getVirtual() as $virtual) {
		echo $this->Fields->control(['name' => $virtual, 'value' => $entry[$virtual]], ['readonly' => true]);
	}
} ?>

<div class="cluster pill">
	<?php if ($action != 'view') : ?>
		<?= $this->Form->button(__('Save Entry'), ['name' => 'save', 'type' => 'button']); ?>
		<?= $this->Form->button(__('Save & Exit')); ?>
	<?php endif ?>
	<?= $this->Html->link("Exit", ["action" => "index", $tableName], ["class" => "button"]) ?>
</div>

<?= $this->Form->end(); ?>

<script>
	window.addEventListener("load", () => {
		const saveButtons = document.querySelectorAll('[name=save]');

		saveButtons.forEach((button) => {
			button.addEventListener('click', async (event) => {
				let form = event.target.closest('form');
				let action = form.getAttribute('action');
				let formData = new FormData(form);
				let data = new URLSearchParams(formData);

				await fetch(action, {
					method: 'post',
					body: data,
				})

				location.reload();
			});
		});
	});
</script>