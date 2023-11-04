<?= $this->Rhino->sectionHeader("String Settings") ?>

<?php $this->start('settings'); ?>
<div class="stack--200">
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		"type" => "textarea",
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>
<?php $this->end('settings'); ?>

<?php $this->start('textEditor'); ?>
<?= $this->Rhino->control("ShowEditor", [
	"value" => $entry->options['showEditor'] ?? '',
	"name" => "settings[showEditor]",
	"type" => "checkbox",
	'description' => "Instead of a plain textarea, show an Editor."
]) ?>
<?php $this->end('textEditor'); ?>

<?= $this->Rhino->getTab([
	'Settings' => 'settings',
	'Text Editor' => 'textEditor',
]); ?>