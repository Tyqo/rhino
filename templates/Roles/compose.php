<section>
	<h1><?= _($action) ?> Role</h1>
	<?= $this->Form->create($entry, ["class" => "stack"]); ?>

	<?= $this->Form->control('name'); ?>

	<figure class="table">
		<table role="grid">
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
						<td>
							<?= $this->Form->checkbox($application . "_" . $type, ['checked' => isset($entry->accessData[$application . "_" . $type]) ? $entry->accessData[$application . "_" . $type] : 1]) ?>
						</td>
					<?php endforeach ?>
				</tr>
			<?php endforeach ?>
		</table>
	</figure>

	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>

	</div>
</section>