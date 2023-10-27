	<h1>Edit User</h1>
	<?= $this->Form->create($entry, ["class" => "stack"]); ?>

	<?= $this->Form->control('name'); ?>

	<div class="table">
		<table>
			<tr>
				<th></th>
				<?php foreach ($accessTypes as $type) : ?>
					<th>
						<?= $type ?>
					</th>
				<?php endforeach ?>
			</tr>
			<?php foreach ($applications as $application) : ?>
				<tr>
					<th><?= $application ?></th>
					<?php foreach ($accessTypes as $type) : ?>
						<th>
							<?= $this->Form->checkbox($application . "_" . $type, ['checked' => isset($entry->accessData[$application . "_" . $type]) ? $entry->accessData[$application . "_" . $type] : 1 ]) ?>
						</th>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</table>
	</div>

	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>

	</div>