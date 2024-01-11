<div class="cluster pill">
	<?php if (isset($view) && $view['valid']) {
		echo $this->Html->link(
			$this->Icon->svg("Rhino.eye"),
			$view['link'],
			[
				'escape' => false,
				'title' => __("View Entry"),
				'class' => 'button'
			]
		);
	}
	?>
	<?php if (isset($edit) && $edit['valid']) {
		echo $this->Html->link(
			$this->Icon->svg("Rhino.edit"),
			$edit['link'],
			[
				'escape' => false,
				'title' => __("Edit Entry"),
				'class' => 'button'
			]
		);
	} ?>
	<?php if (isset($duplicate) && $duplicate['valid']) {
		echo $this->Html->link(
			$this->Icon->svg("Rhino.copy"),
			$duplicate['link'],
			[
				'escape' => false,
				'title' => __("Duplicate Entry"),
				'class' => 'button'
			]
		);
	} ?>
	<?php if (isset($delete) && $delete['valid']) {
		echo $this->Rhino->post(
			$this->Icon->svg("Rhino.trash"),
			$delete['link'],
			[
				'confirm' => $delete['confirm'],
				'escape' => false,
				'title' => __("Delete Entry"),
				'class' => 'button'
			]
		);
	} ?>
</div>
