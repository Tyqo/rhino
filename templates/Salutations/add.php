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
            <?= $this->Html->link(__('List Salutations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salutations form content">
            <?= $this->Form->create($salutation) ?>
            <fieldset>
                <legend><?= __('Add Salutation') ?></legend>
                <?php
                    echo $this->Form->control('salutation');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
