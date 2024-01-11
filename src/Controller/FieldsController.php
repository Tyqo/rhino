<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\RhinoController;
use Rhino\Handlers\FieldHandler;
use App\View\AjaxView;

class FieldsController extends RhinoController
{
    public function index(string $tableName) {
        $columns = $this->Fields->getColumns($tableName);

        $this->set([
			"tableName" => $tableName,
			"columns" => $columns,
			"rows" => $this->Fields->rows
		]);
    }


	public function add(string $tableName) {
        // TODO: Catch and handle error if duplicate column/field name
		$entry = $this->Fields->newEmptyEntity();
		$this->set(['title' => 'Add']);
		$this->compose($entry, ["redirect" => ['action' => 'index', $tableName]]);
	}


    public function duplicate(string $tableName, string $fieldName) {
        $oldEntry = $this->Fields->getByName($fieldName, $tableName);
        $newEntry = $this->Fields->newEmptyEntity();
        $this->Fields->patchEntity($newEntry, $oldEntry->toArray());
        $newEntry->isNew(true);
        unset($newEntry->id);
        $this->set(['title' => __('Duplicate')]);
        $this->compose($newEntry, ['redirect' => ['action' => 'index', $tableName]]);
    }


	public function edit(string $tableName, string $fieldName) {
        $entry = $this->Fields->getByName($fieldName, $tableName);
		$this->set(['title' => 'Edit']);
		$this->compose($entry, ["redirect" => ['action' => 'index', $tableName]]);
	}


	public function preCompose($entry, ...$params) {
		$tableName = $params[0];
		$field = $params[1] ?? null;

		$types = $this->FieldHandler->customTypes;
		$typeOptions = $this->FieldHandler->getTypes();

		$apps = ['test', 'alt'];

		$this->set([
			"tableName" => $tableName,
			"typeOptions" => $typeOptions,
			"types" => $types,
			'settings' => $entry->settings,
			'applications' => $apps
		]);

		$options = $this->FieldHandler->loadFiledOptions();
		$this->set($options);
	}

	public function preSave($data, $params) {
		if (isset($data['settings'])) {
			$data['settings'] = json_encode($data['settings']);
		}

		$pass = $this->request->getParam('pass');
		$tableName = $pass[0];
		$data = $this->FieldHandler->setFieldData($data);

		$dbData = $data;
		$dbData['type'] = $this->FieldHandler->getDatabaseType($data['type']);

        if ($params['action'] == 'add' || $params['action'] == 'duplicate') {
			$this->Fields->create($tableName, $dbData);
		} else {
			if ($data['name'] != $data['currentName']) {
				$this->Fields->rename($tableName, $dbData["currentName"], $dbData["name"]);
			}
			$this->Fields->update($tableName, $dbData["name"], $dbData);
		}
		return $data;
	}

	public function delete(string $tableName, string $field) {
		$entry = $this->Fields->getByName($field, $tableName);
		$this->Fields->drop($tableName, $field);
		if ($entry) {
			$this->Fields->delete($entry);
		}
		return $this->redirect(['action' => 'index', $tableName]);
	}


	public function getOptions($tableName, $type, $fieldName = null) {
		if (isset($fieldName)) {
			$field = $this->Fields->getByName($fieldName, $tableName);

			if (isset($field['settings'])) {
				$values = $field['settings'];
			}
		}

		if (empty($settings)) {
			$template = 'databaseOptions';
			$columns = $this->prepareSelect(
				$this->FieldHandler->listColumns($tableName)
			);
			$this->set([
				"columns" => $columns,
			]);
		} else {
			$template = 'customOptions';
			$this->set([
				"settings" => $settings,
			]);
		}

		try {
			$this->viewBuilder()->disableAutoLayout();
			$content = $this->render($template);
			$this->viewBuilder()->enableAutoLayout();
			return $content;
		} catch (MissingTemplateException $exception) {
			if (Configure::read('debug')) {
				throw $exception;
			}
			throw new NotFoundException();
		}
	}
}
