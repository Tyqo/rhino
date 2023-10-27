	<div class="stack--200">
		<?= $this->Form->control('comment', ["type" => "textarea"]); ?>
	</div>

	<div class="stack--200">
		<?= $this->Form->control("default") ?>
	</div>

	<div class="stack--200">
		<?= $this->Form->control('limit', ["type" => "number"]); ?>
	</div>

	<div class="stack--200">
		<?= $this->Form->control('after', ["type" => "select", "options" => $columns]); ?>
	</div>

	<div class="stack--200">
		<?= $this->Form->control('signed', ["type" => "checkbox"]); ?>
	</div>

	<details class="stack--200">
		<summary>For decimal:</summary>

		<div class="stack--200">
			<?= $this->Form->control('precision'); ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control('scale'); ?>
		</div>
	</details>

	<details class="stack--200">
		<summary>For enum and set:</summary>

		<div class="stack--200">
			<?= $this->Form->control('values'); ?>
		</div>
	</details class="stack--200">

	<details class="stack--200">
		<summary>For timestamp:</summary>

		<div class="stack--200">
			<?= $this->Form->control('current_time', ["type" => "checkbox"]); ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control('update', ["type" => "checkbox"]); ?>
		</div>

		<div class="stack--200">
			<?= $this->Form->control('timezone'); ?>
		</div>
	</details>