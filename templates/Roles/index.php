<div class="tables index content stack">
	<div class="table-wrapper">
		<table>
			<caption><?= __('Roles') ?></caption>
			<thead>
				<tr>
					<th><?= $this->Paginator->sort('id') ?></th>
					<th><?= $this->Paginator->sort('name') ?></th>
					<th><?= $this->Paginator->sort('created') ?></th>
					<th><?= $this->Paginator->sort('modified') ?></th>

					<th class="actions" align="right"><?= __('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($roles as $role) : ?>
					<tr>
						<td><?= $this->Number->format($role->id) ?></td>
						<td><?= h($role->name) ?></td>
						<td><?= h($role->created) ?></td>
						<td><?= h($role->modified) ?></td>

						<td class="actions">
							<?php
							$this->start('actions');
							echo $this->element("layout-elements/actions", [
								"edit" => [
									"link" => ['action' => 'edit', $role->id],
									"valid" => in_array('edit', $rights)
								],
								"delete" => [
									"link" => ['action' => 'delete', $role->id],
									"valid" => in_array('delete', $rights),
									"confirm" => __('Are you sure you want to delete # {0}?', $role->id),
								],
							]);
							$this->end();
							?>
							<?= $this->fetch('actions'); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<?= $this->Html->link(__('New Role'), ['action' => 'add'], ['class' => 'button float-right']) ?>

	<?= $this->element('pagination') ?>
</div>