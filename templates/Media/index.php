<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\Cake\Datasource\EntityInterface> $media
 */
?>
<section class="rhinoMedia index content">
    <?= $this->Html->link(__('New Rhino Media'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Rhino Media') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('filename') ?></th>
                    <th><?= $this->Paginator->sort('filetype') ?></th>
                    <th><?= $this->Paginator->sort('position') ?></th>
                    <th><?= $this->Paginator->sort('media_category_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($media as $media): ?>
                <tr>
                    <td><?= $this->Number->format($media->id) ?></td>
                    <td><?= h($media->filename) ?></td>
                    <td><?= h($media->filetype) ?></td>
                    <td><?= $media->position === null ? '' : $this->Number->format($media->position) ?></td>
                    <td><?= $media->hasValue('media_category') ? $this->Html->link($media->media_category->name, ['controller' => 'MediaCategories', 'action' => 'view', $media->media_category->id]) : '' ?></td>
                    <td><?= h($media->created) ?></td>
                    <td><?= h($media->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $media->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $media->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $media->id], ['confirm' => __('Are you sure you want to delete # {0}?', $media->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</section>
