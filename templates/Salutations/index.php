<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Salutation> $salutations
 */
?>
<div class="salutations index content">
    <?= $this->Html->link(__('New Salutation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Salutations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('salutation') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salutations as $salutation): ?>
                <tr>
                    <td><?= $this->Number->format($salutation->id) ?></td>
                    <td><?= h($salutation->salutation) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $salutation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salutation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salutation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salutation->id)]) ?>
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
</div>
