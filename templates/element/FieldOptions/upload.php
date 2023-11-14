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
		'types' => 'folder',
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