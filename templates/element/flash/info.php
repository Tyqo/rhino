<?php

/**
 * @var \App\View\AppView $this
 * @var array $params
 * @var string $message
 */
$params['class'] = 'info';
?>

<?= $this->element("flash/default", [
	'message' => $message,
	'params' => $params
]) ?>