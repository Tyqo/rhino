<?php $this->assign('title', 'login') ?>

<div class="users">
	<article>
		<div class="center">
			<?= $this->svg("Rhino.rhino-big") ?>
			<h3 class="sr-only">Login</h3>
		</div>

		<?= $this->Form->create(null, ['class' => 'stack']) ?>
		<fieldset>
			<?= $this->Form->control('email', ['required' => true]) ?>
			<?= $this->Form->control('password', ['required' => true]) ?>
			<?= $this->Form->control('remember_me', ['type' => 'checkbox', 'role' => 'switch']) ?>
		</fieldset>
		<?= $this->Form->submit(__('Login')); ?>
		<?= $this->Form->end() ?>
	</article>
</div>