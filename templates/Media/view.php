<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $media
 */
?>
<section class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Rhino Media'), ['action' => 'edit', $media->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Rhino Media'), ['action' => 'delete', $media->id], ['confirm' => __('Are you sure you want to delete # {0}?', $media->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Rhino Media'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Rhino Media'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="rhinoMedia view content">
            <h3><?= h($media->filename) ?></h3>
            <table>
                <tr>
                    <th><?= __('Filename') ?></th>
                    <td><?= h($media->filename) ?></td>
                </tr>
                <tr>
                    <th><?= __('Filetype') ?></th>
                    <td><?= h($media->filetype) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rhino Media Category') ?></th>
                    <td><?= $media->hasValue('rhino_media_category') ? $this->Html->link($media->rhino_media_category->name, ['controller' => 'RhinoMediaCategories', 'action' => 'view', $media->rhino_media_category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($media->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= $media->position === null ? '' : $this->Number->format($media->position) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($media->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($media->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($media->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</section>
