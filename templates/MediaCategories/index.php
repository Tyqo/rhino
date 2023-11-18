<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $mediaCategories
 */
?>
<section class="mediaCategories index content stack">
	<h3><?= __('Media Categories') ?></h3>
	<div class="auto-grid">
		<?php foreach ($mediaCategories as $mediaCategory): ?>
		<div class="stack box">
			<h4><?= h($mediaCategory->name) ?></h4>

			<?php $this->start('actions');
				echo $this->element("layout-elements/actions", [
					"view" => [
						"link" => ['action' => 'view', $mediaCategory->id],
						"valid" => in_array('view', $rights)
					],
					"edit" => [
						"link" => ['action' => 'edit', $mediaCategory->id],
						"valid" => in_array('edit', $rights)
					],
					"delete" => [
						"link" => ['action' => 'delete', $mediaCategory->id],
						"valid" => in_array('edit', $rights),
						"confirm" => __('Are you sure you want to delete # {0}?', $mediaCategory->id),
					],
				]);
			$this->end();
			?>
			<?= $this->fetch('actions'); ?>
		</div>
		<?php endforeach; ?>
	</div>
	<?= $this->Html->link(__('New Media Category'), ['action' => 'add'], ['class' => 'button float-right']) ?>
</section>