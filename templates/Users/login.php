<?php $this->assign('title', 'login') ?>

<div class="box box--alt form stack">
	<div class="center login-logo">
		<?= $this->svg("Tusk.tusk-big") ?>
	</div>
	
    <?= $this->Form->create(null, ['class' => 'stack']) ?>
		<?= $this->Form->control('email', ['required' => true]) ?>
		<?= $this->Form->control('password', ['required' => true]) ?>
		<?= $this->Form->control('remember_me', ['type' => 'checkbox']) ?>
		<?= $this->Form->submit(__('Login'), ['class' => 'button']); ?>
    <?= $this->Form->end() ?>
</div>