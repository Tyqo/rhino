<div>
	<?= $this->Rhino->sectionHeader("Upload Settings") ?>
</div>

<div>
	<?= $this->Rhino->control("default", [
		"value" => $entry->standard,
		"type" => 'directory',
		'types' => 'file',
		'description' => "Standard value to use in a new Entry."
	]) ?>
</div>

<div>
	<?= $this->Rhino->control("fileSelect", [
		"value" => $entry->options['uploadDirectory'] ?? '',
		"name" => "settings[uploadDirectory]",
		"type" => 'directory',
		'types' => 'directory',
		'description' => "Path where the files will be saved."
	]) ?>
</div>

<div>
	<?= $this->Rhino->control("fileTypes", [
		"value" => $entry->options['uploadTypes'] ?? '',
		"name" => "settings[uploadTypes]",
		'description' => "The selectable File Types."
	]) ?>
</div>

<?= $this->Rhino->control("uploadOverwrite", [
	"value" => $entry->options['uploadOverwrite'] ?? '',
	"name" => "settings[uploadOverwrite]",
	"type" => "checkbox",
	'description' => "Overwrite existing file."
]) ?>

<?= $this->Rhino->control("uploadMultiple", [
	"value" => $entry->options['uploadMultiple'] ?? '',
	"name" => "settings[uploadMultiple]",
	"type" => "checkbox",
	'description' => "Allow multiple Files. Will be saved as comma separated list."
]) ?>