<?php foreach ($nodes as $node) : ?>
	<li class="page-item">
		<div class="page-item__body node-type-<?= $node['node_type'] ?>">
			<?= $this->Html->link($node['name'], ['action' => 'layout', $node['id']], ['class' => 'button outline']) ?>

			<div class="page-item__actions">

				<div class="cluster pill">
					<?php
					echo $this->Html->Link($this->Icon->svg('arrow-up'), ['action' => 'moveUp', $node->id], ['escape' => false, 'class' => 'button']);
					echo $this->Html->Link($this->Icon->svg('arrow-down'), ['action' => 'moveDown', $node->id], ['escape' => false, 'class' => 'button']);
					?>
				</div>

				<?php
				$this->start('actions');
				echo $this->element("layout-elements/actions", [
					"view" => [
						"link" => ['action' => 'layout', $node['id']],
						"valid" => in_array('view', $rights)
					],
					"edit" => [
						"link" => ['action' => 'edit', $node['id']],
						"valid" => in_array('edit', $rights)
					],
					"delete" => [
						"link" => ['action' => 'delete', $node['id']],
						"valid" => in_array('delete', $rights),
						"confirm" => __('Are you sure you want to delete # {0}?', $node['name']),
					]
				]);

				$this->end();
				?>
				<?= $this->fetch('actions'); ?>
			</div>

		</div>

		<?php if (!empty($node['children'])) : ?>
			<ul>
				<?= $this->element('Pages/node_item', [
					'nodes' => $node['children']
				]) ?>
			</ul>
		<?php endif ?>
	</li>
<?php endforeach ?>

<style>
	.node-type-0 {
		--primary: skyblue;
	}
	.node-type-1 {
		--primary: limegreen;
	}
	.node-type-2 {
		--primary: firebrick;
	}
</style>