<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $widgetCategory
 */
?>
<section class="cluster">

	<div class="column column-80">
		<div class="rhinoWidgetCategories view content">
			<h3><?= h($widgetCategory->name) ?></h3>

			<?php if (!empty($widgetCategory->description)) : ?>
				<div class="text">
					<blockquote>
						<?= $this->Text->autoParagraph(h($widgetCategory->description)); ?>
					</blockquote>
				</div>
			<?php endif ?>

			<div class="related">
				<h4><?= __('Widget') ?></h4>
				<?= $this->Html->link(__('New'), ['controller' => 'widget', 'action' => 'add', $widgetCategory->id]) ?>

				<?php if (!empty($widgetCategory->widgets)) : ?>
					<div class="auto-grid">
						<?php foreach ($widgetCategory->widgets as $widget) : ?>
							<div class="stack box">

								<figure>
									<figcaption>
										<small><?= h($widget->template) ?></small>
									</figcaption>
									<?= $this->Rhino->displayField('template', $widget) ?>
								</figure>

								<div class="stack">
									<?= $this->Rhino->displayField('position', $widget) ?>
									<?php $this->start('actions');
									echo $this->element("layout-elements/actions", [
										"view" => [
											"link" => ['controller' => 'Widgets', 'action' => 'view', $widget->id],
											"valid" => in_array('view', $rights)
										],
										"edit" => [
											"link" => ['controller' => 'Widgets', 'action' => 'edit', $widget->id],
											"valid" => in_array('edit', $rights)
										],
										"delete" => [
											"link" => ['controller' => 'Widgets', 'action' => 'delete', $widget->id],
											"valid" => in_array('edit', $rights),
											"confirm" => __('Are you sure you want to delete # {0}?', $widget->id),
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
			<?= $this->Html->link(__('Edit Widget Category'), ['action' => 'edit', $widgetCategory->id], ['class' => 'side-nav-item']) ?>
			<?= $this->Form->postLink(__('Delete Widget Category'), ['action' => 'delete', $widgetCategory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $widgetCategory->id), 'class' => 'side-nav-item']) ?>
			<?= $this->Html->link(__('List Widget Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
			<?= $this->Html->link(__('New Widget Category'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
		</div>
	</aside>
</section>
