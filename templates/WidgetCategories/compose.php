<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $widgetCategory
 */
?>
<section class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $widgetCategory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $widgetCategory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Widget Categories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="widgetCategories form content">
            <?= $this->Form->create($widgetCategory) ?>
            <fieldset>
                <legend><?= __('Edit Widget Category') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>
