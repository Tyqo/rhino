<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $users
 */
?>

<div class="tables index content stack">
	<div class="table-wrapper">
		<table>
			<caption><?= __('Users') ?></caption>
			<thead>
				<tr>
					<th><?= $this->Paginator->sort('id') ?></th>
					<th><?= $this->Paginator->sort('email') ?></th>
					<th><?= $this->Paginator->sort('created') ?></th>
					<th><?= $this->Paginator->sort('modified') ?></th>
					<th class="actions" align="right"><?= __('Actions') ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($users as $user) : ?>
					<tr>
						<td><?= $this->Number->format($user->id) ?></td>
						<td><?= h($user->email) ?></td>
						<td><?= h($user->created) ?></td>
						<td><?= h($user->modified) ?></td>
						<td class="actions">
							<?php
							$this->start('actions');
							echo $this->element("layout-elements/actions", [
								"edit" => [
									"link" => ['action' => 'edit', $user->id],
									"valid" => in_array('edit', $rights)
								],
								"delete" => [
									"link" => ['action' => 'delete', $user->id],
									"valid" => in_array('delete', $rights),
									"confirm" => __('Are you sure you want to delete # {0}?', $user->id),
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

	<?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>

	<?= $this->element('pagination') ?>
</div>