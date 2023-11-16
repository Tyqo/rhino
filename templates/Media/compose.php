<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $media
 * @var string[]|\Cake\Collection\CollectionInterface $mediaCategories
 */
?>
<section class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $entry->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $entry->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Rhino Media'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="rhinoMedia form content">
            <?= $this->Form->create($entry) ?>
            <fieldset>
                <legend><?= __('Edit Rhino Media') ?></legend>
                <?php
                    echo $this->Rhino->control('filename');
                    echo $this->Form->control('description');
                    echo $this->Form->hidden('filetype');
                    echo $this->Form->hidden('position');
                    echo $this->Form->hidden('media_category_id');
                ?>

				<?= $this->Rhino->render($fields, $entry, []) ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>
