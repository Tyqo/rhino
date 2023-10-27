<div class="stack">
	<h1><?= $tableName ?></h1>
	<div class="table-wrapper">
		<table>
			<caption><?= __('Table fields') ?></caption>
			<tr>
				<?php foreach ($rows as $row) : ?>
					<th><?= $row ?></th>
				<?php endforeach ?>
				<th>Actions</th>
			</tr>
			<?php if (!empty($columns)) : ?>
				<?php foreach ($columns as $column) : ?>
					<tr>
						<?php foreach ($rows as $row) : ?>
							<td><?= $column[$row] ?></td>
						<?php endforeach ?>
						<td>
							<?php
							$this->start('actions');
							echo $this->element("layout-elements/actions", [
								"edit" => [
									"link" => ['action' => 'edit', $tableName, $column["Field"]],
									"valid" => in_array('edit', $rights)
								],
								"delete" => [
									"link" => ['action' => 'delete', $tableName, $column["Field"]],
									"valid" => in_array('edit', $rights),
									"confirm" => __('Are you sure you want to delete: {0}?', $column["Field"]),
								],
							]);
							$this->end();
							?>
							<?= $this->fetch('actions'); ?>
						</td>
					</tr>
				<?php endforeach ?>
			<?php endif ?>
		</table>
	</div>

	<?= $this->Html->link("Add Cloumn", ["controller" => "Fields", "action" => "add", $tableName], ["class" => "button"]) ?>
	<?= $this->Html->link("Back", ['controller' => 'applications'], ["class" => "button"]); ?>
</div>