<div>
	<?= $this->Rhino->sectionHeader("Upload Settings") ?>
</div>

<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>

<div>
	<?= $this->Rhino->control("fileSelect", [
		"value" => $entry->options['uploadDirectory'] ?? '',
		"name" => "settings[uploadDirectory]",
		"type" => 'directory',
		'description' => "Path where the files will be saved."
	]) ?>
</div>

<?= $this->Rhino->control("uploadOverwrite", [
	"value" => $entry->options['uploadOverwrite'] ?? '',
	"name" => "settings[uploadOverwrite]",
	"type" => "checkbox",
	'description' => "Overwrite existing file."
]) ?>