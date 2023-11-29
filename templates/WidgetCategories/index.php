<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $widgetCategories
 */
?>
<section class="widgetCategories index content">
    <h3><?= __('Widget Categories') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= _('Name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($widgetCategories as $widgetCategory): ?>
                <tr>
                    <td><?= h($widgetCategory->name) ?></td>
                    <td class="actions" data-cell="Actions">
                        <?php $this->start('actions');
							echo $this->element("layout-elements/actions", [
								"view" => [
									"link" => ['action' => 'view', $widgetCategory->id],
									"valid" => in_array('view', $rights)
								],
								"edit" => [
									"link" => ['action' => 'edit', $widgetCategory->id],
									"valid" => in_array('edit', $rights)
								],
								"delete" => [
									"link" => ['action' => 'delete', $widgetCategory->id],
									"valid" => in_array('edit', $rights),
									"confirm" => __('Are you sure you want to delete # {0}?', $widgetCategory->id),
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

	<?= $this->Html->link(__('New Widget Category'), ['action' => 'add'], ['class' => 'button float-right']) ?>
</section>
