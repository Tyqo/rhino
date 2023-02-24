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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $salutation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $salutation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Salutations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salutations form content">
            <?= $this->Form->create($salutation) ?>
            <fieldset>
                <legend><?= __('Edit Salutation') ?></legend>
                <?php
                    echo $this->Form->control('salutation');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
