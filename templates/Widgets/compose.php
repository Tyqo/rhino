<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $widget
 */
?>
<section class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $widget->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $widget->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Widgets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="widgets form content">
            <?= $this->Form->create($widget) ?>
            <fieldset>
                <legend><?= __('Edit Widget') ?></legend>
				<?= $this->Rhino->render($fields, $widget, []) ?>
			</fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>
