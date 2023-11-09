<?php
	$options = explode(",", $params['settings']['options']);
	$multiSelect = !empty($params['settings']['multiSelect']);
	$allowEmpty = !empty($params['settings']['allowEmpty']);

	function isSelected($option, $params) {
		if (isset($params['value'])) {
			if (trim($option) == $params['value']) {
				return 'selected';
			}
		} else {
			$defaults = explode(',', $params['settings']['defaults']);
			if (in_array(trim($option), $defaults)) {
				return 'selected';
			}
		}
		return '';
	}
?>
<div class="input <?= isset($params['class']) ? $params['class'] : "" ?>">
	<label for="<?= $params['name'] ?>"><?= $params['alias'] ?></label>

	<select name="<?= $params['name'] . ($multiSelect ? '[]' : '') ?>" id="<?= $params['name'] ?>" <?php if($multiSelect) echo 'multiple'; ?>>
		<?php if ($allowEmpty) : ?>
			<option value="">--- empty ---</option>
		<?php endif ?>
		<?php foreach ($options as $option) : ?>
			<option value="<?= trim($option) ?>" <?= isSelected(trim($option), $params) ?>><?= trim($option) ?></option>
		<?php endforeach ?>
	</select>

	<?php if (isset($params['description'])) : ?>
		<p><?= $params['description'] ?></p>
	<?php endif ?>
</div>