<?php foreach ($settings as $key => $params) : ?>
	<?= $this->Fields->control([
		'name' => $key,
		'type' => $params['type'],
		'value' => isset($params['value']) ? $params['value'] : $params['default'],
		'description' => $params['description'],
		'settings' => isset($params['settings']) ? $params['settings'] : []
	]); ?>
<?php endforeach ?>