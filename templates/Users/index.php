<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $users
 */
?>

<section class="users index content stack">
	<figure>
		<table role="grid">
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
	</figure>

	<?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>

	<?= $this->element('pagination') ?>
</section>