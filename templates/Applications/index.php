<section class="index content stack">

	<figure>
		<table role="grid">
			<caption><?= __('Application-Manager') ?></caption>
			<thead>
				<tr>
					<th colspan="2">Table</th>
					<th data-cell="Actions" align="right">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php if (empty($groups)) : ?>
					<tr>
						<td colspan="3" align="center">
							No Applications found.
						</td>
					</tr>
				<?php endif ?>

				<?php foreach ($groups as $group) : ?>
					<tr>
						<td colspan="2"><b><?= $group['name'] ?></b></td>
						<td data-cell="Actions">
							<?php if (isset($group['id'])) : ?>
								<?php
								$this->start('actions');
								echo $this->element("layout-elements/actions", [
									"edit" => [
										"link" => ['action' => 'renameGroup', $group['id']],
										"valid" => in_array('edit', $rights)
									],
									"delete" => [
										"link" => ['action' => 'deleteGroup', $group['id']],
										"valid" => in_array('edit', $rights),
										"confirm" => __('Are you sure you want to delete the group: {0}?', $group['name']),
									],
								]);
								$this->end();
								?>
								<?= $this->fetch('actions'); ?>
							<?php endif ?>
						</td>
					</tr>
					<?php foreach ($group['applications'] as $table) : ?>
						<tr>
							<td>
								<?= $this->Html->link(
									isset($table['alias']) ? $table['alias'] : $table['name'],
									["controller" => "Tables", "action" => 'index', $table['name']],
									['class' => 'button outline']
								) ?>
							</td>
							<td data-cell="Actions" colspan="2">
								<?php
								$this->start('actions');
								echo $this->element("layout-elements/actions", [
									"view" => [
										"link" => ["controller" => "Fields", "action" => 'index', $table['name']],
										"valid" => in_array('view', $rights)
									],
									"edit" => [
										"link" => ['action' => 'edit', $table['name']],
										"valid" => in_array('edit', $rights)
									],
									"delete" => [
										"link" => ['action' => 'delete', $table['name']],
										"valid" => in_array('edit', $rights),
										"confirm" => __('Are you sure you want to delete: {0}?', $table['name']),
									],
								]);
								$this->end();
								?>
								<?= $this->fetch('actions'); ?>
							</td>
						</tr>
					<?php endforeach ?>
				<?php endforeach ?>
			</tbody>
		</table>
	</figure>

	<?= $this->Html->link("Create new Table", ["action" => "add"], ["class" => "button"]) ?>
	<?= $this->Html->link("Create new Group", ["action" => "newGroup"], ["class" => "button"]) ?>
</section>