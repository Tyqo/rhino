<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Salutation $salutation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Salutation'), ['action' => 'edit', $salutation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Salutation'), ['action' => 'delete', $salutation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salutation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Salutations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Salutation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salutations view content">
            <h3><?= h($salutation->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Salutation') ?></th>
                    <td><?= h($salutation->salutation) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($salutation->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
