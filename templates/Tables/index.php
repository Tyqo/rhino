<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $tables
 */

?>
<div class="tables index content stack">

	<?= $this->Form->create(null, [
			'url' => [
				'action' => 'setFilter',
				$tableName
			], 'type' => 'post', 'class' => 'cluster']) 
		?>

		<div class="cluster cluster--even pill">
			<?= $this->Form->select("field", $columns, ['value' => $field]) ?>
			<?= $this->Form->select("operator", $operators, ['value' => $operator]) ?>
			<?= $this->Form->input("query", ['value' => $query]) ?>
		</div>

		<div class="cluster pill">
			<?= $this->Form->button("Filter") ?>
			<?= $this->Html->Link('clear Filter', [
				'action' => 'clearFilter',
				$tableName
			],
			['class' => 'alt-button'])
			?>
		</div>
	<?= $this->Form->end() ?>

	<div class="table-wrapper">
		<table>
			<caption class="caption"><?= __(!empty($app['alias']) ? $app['alias'] : $app['name']) ?></caption>
			<thead>
				<tr>
					<?php foreach ($columns as $column) : ?>
						<?php if (!empty($app->overviewData) && !in_array($column, $app->overviewData)) {
							continue;
						} ?>
						<th data-cell="<?= h(ucfirst($column)) ?>"><?= $this->Paginator->sort($column) ?></th>
					<?php endforeach ?>

					<th align="right" data-cell="Actions"><?= __('Actions') ?></th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($data as $entry) : ?>
					<tr>
						<?php foreach ($columns as $column) : ?>
							<?php if (!empty($app->overviewData) && !in_array($column, $app->overviewData)) {
								continue;
							} ?>
							<td data-cell="<?= h(ucfirst($column)) ?>"><?= h($entry->{$column}) ?></td>
						<?php endforeach ?>

						<td class="actions" data-cell="Actions">
							<?php
							$this->start('actions');
							echo $this->element("layout-elements/actions", [
								"view" => [
									"link" => ['action' => 'view', $tableName, $entry->id],
									"valid" => in_array('view', $rights)
								],
								"edit" => [
									"link" => ['action' => 'edit', $tableName, $entry->id],
									"valid" => in_array('edit', $rights)
								],
								"delete" => [
									"link" => ['action' => 'delete', $tableName, $entry->id],
									"valid" => in_array('edit', $rights),
									"confirm" => __('Are you sure you want to delete # {0}?', $entry->id),
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

	<div class="cluster pill">
		<?php
		if (in_array('add', $rights)) {
			$newButton = $this->svg("Tusk.plus") . '<span>' . __('New Entry') . '</span>';
			echo $this->Html->link($newButton, ['action' => 'add', $tableName], ['escape' => false, 'class' => 'button icon-button']);
		} ?>

		<?= $this->Html->link($this->svg("Tusk.download") . '<span>' . __('Export to CSV') . '</span>', ['action' => 'export', $tableName], ['escape' => false, 'class' => 'button icon-button', 'download' => $tableName . '.csv']); ?>
	</div>



	<?= $this->element('pagination') ?>
</div>