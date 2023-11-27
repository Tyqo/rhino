<?php $this->assign('title', 'new User') ?>

<div class="login">
	<article>
		<div class="center">
			<?= $this->Icon->svg("Rhino.rhino-big") ?>
		</div>
		
		<?= $this->Form->create($user, ['class' => 'stack']) ?>
		<fieldset>
			<legend>Create new User</legend>
			<?= $this->Form->control('name', ['required' => true]) ?>
			<?= $this->Form->control('email', ['required' => true]) ?>
			<?= $this->Form->control('newPassword', ['type' => 'password', 'value' => '', 'required' => true]); ?>
			<?= $this->Form->control('repeatPassword', ['type' => 'password', 'value' => '', 'required' => true]); ?>
			<?= $this->Form->hidden('role_id', ['value' => 1]); ?>
		</fieldset>
		<?= $this->Form->submit(__('Create')); ?>
		<?= $this->Form->end() ?>
	</article>
</div>