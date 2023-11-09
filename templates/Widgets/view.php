<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $widget
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Widget'), ['action' => 'edit', $widget->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Widget'), ['action' => 'delete', $widget->id], ['confirm' => __('Are you sure you want to delete # {0}?', $widget->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Widgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Widget'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="widgets view content">
            <h3><?= h($widget->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($widget->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($widget->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
