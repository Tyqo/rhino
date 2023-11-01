<?php

/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $user
 */
?>

<section>
	<h1><?= __($action) ?> User</h1>
	<?= $this->Form->create($user); ?>

	<?php
		echo $this->Form->control('name');
		echo $this->Form->control('email');
		echo $this->Form->control('theme');

		if ($role == 1) {
			echo $this->Form->control('role_id');
		}

		echo $this->Form->control('newPassword', ['type' => 'text', 'value' => '', 'required' => false]);
		echo $this->Form->control('repeatPassword', ['type' => 'text', 'value' => '', 'required' => false]);
	?>

	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>

</section>