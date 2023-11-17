<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $mediaCategory
 */
?>
<section class="cluster">

	<div class="column column-80">
		<div class="rhinoMediaCategories view content">
			<h3><?= h($mediaCategory->name) ?></h3>

			<?php if (!empty($mediaCategory->description)) : ?>
				<div class="text">
					<blockquote>
						<?= $this->Text->autoParagraph(h($mediaCategory->description)); ?>
					</blockquote>
				</div>
			<?php endif ?>

			<div class="related">
				<h4><?= __('Media') ?></h4>
				<?= $this->Html->link(__('New'), ['controller' => 'media', 'action' => 'add', $mediaCategory->id]) ?>

				<?php if (!empty($mediaCategory->media)) : ?>
					<div class="cluster">
						<?php foreach ($mediaCategory->media as $media) : ?>
							<div class="stack box">

								<figure>
									<figcaption>
										<small><?= h($media->filename) ?></small>
									</figcaption>
									<?= $this->Rhino->displayField('filename', $media) ?>
								</figure>

								<div class="stack">
									<?= $this->Rhino->displayField('position', $media) ?>
									<?php $this->start('actions');
									echo $this->element("layout-elements/actions", [
										"view" => [
											"link" => ['controller' => 'media', 'action' => 'view', $media->id],
											"valid" => in_array('view', $rights)
										],
										"edit" => [
											"link" => ['controller' => 'media', 'action' => 'edit', $media->id],
											"valid" => in_array('edit', $rights)
										],
										"delete" => [
											"link" => ['controller' => 'media', 'action' => 'delete', $media->id],
											"valid" => in_array('edit', $rights),
											"confirm" => __('Are you sure you want to delete # {0}?', $media->id),
										],
									]);
									$this->end();
									?>
									<?= $this->fetch('actions'); ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<aside class="column">
		<div class="side-nav stack">
			<h4 class="heading"><?= __('Actions') ?></h4>
			<?= $this->Html->link(__('Edit Media Category'), ['action' => 'edit', $mediaCategory->id], ['class' => 'side-nav-item']) ?>
			<?= $this->Form->postLink(__('Delete Media Category'), ['action' => 'delete', $mediaCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mediaCategory->id), 'class' => 'side-nav-item']) ?>
			<?= $this->Html->link(__('List Media Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
			<?= $this->Html->link(__('New Media Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
		</div>
	</aside>
</section>