<div class="input <?= isset($params['class']) ? $params['class'] : "" ?>">
	<label for="<?= $params['name'] ?>"><?= $params['alias'] ?></label>
	<input id="<?= $params['name'] ?>" name="<?= $params['name'] ?>" value="<?= $params['value'] ?>" type="file">
	<?php if (isset($params['description'])) : ?>
		<p><?= $params['description'] ?></p>
	<?php endif ?>
</div>