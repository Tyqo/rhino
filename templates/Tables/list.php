<div>
	<h1>Tables</h1>
	<ul>
		<?php foreach ($tables as $table) : ?>
			<?php if ($table == "users") : ?>
				<li><?= $this->Html->link($table, ["controller" => $table]) ?></li>
			<?php else : ?>
				<li><?= $this->Html->link($table, ["action" => 'view', $table]) ?></li>
			<?php endif ?>
		<?php endforeach ?>
	</ul>
</div>