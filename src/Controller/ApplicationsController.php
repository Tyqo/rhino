<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\AppController;
use Rhino\Model\Table\GroupsTable;

/**
 * Tables Controller
 *
 * @method \Rhino\Model\Entity\Table[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ApplicationsController extends AppController {

	public function initialize(): void {
		parent::initialize();
		$this->Groups = new GroupsTable();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
		$groups = $this->Groups->find()->contain(['Applications'])->all()->toArray();

        $apps = $this->Applications->find()->where(
			function ($exp) {
				return $exp->isNotNull("rhino_group_id");
			}
		)->all()->toArray();

		$_ungrouped = $this->Applications->getList(array_column($apps, 'name'));
		$ungrouped = [];
		
		foreach ($_ungrouped as $key => $value) {
			$ungrouped[] = ['name' => $value];
		}

		if (!empty($ungrouped)) {
			$groups[] = [
				"name" => "Ungrouped",
				"applications" => $ungrouped
			];
		}

		$rhinoTables = $this->Applications->tableBlackList;

        $this->set(compact('groups', 'rhinoTables'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

		$entry = $this->Applications->newEmptyEntity();

		$this->compose($entry, [
			'success' => __('The table has been saved.'),
			'error' => __('The table could not be saved. Please, try again.')
		]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Table id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function edit($tableName) {
		$entry = $this->Applications->getByName($tableName);
		
		if (!$entry) {
			$entry = $this->Applications->newEmptyEntity();
			$entry['name'] = $tableName;
		}

		$this->set([
			"tableName" => $tableName
		]);

		$this->compose($entry, [
			'success' => __('The table has been saved.'),
			'error' => __('The table could not be saved. Please, try again.')
		]);
	}

	public function preCompose($entry, ...$params) {
		$tableName = $params[0] ?? null;

		$groups = $this->Groups->getGroups();

		if (!empty($tableName)) {
			$appFields = $this->FieldHandler->listColumns($tableName);
			$this->set([
				"appFields" => $this->setValueAsKey($appFields)
			]);
		}

		$this->set([
			'groups' => $this->addEmptyOption($groups),
		]);

		return $entry;
	}

	public function preSave($data, $params) {
		if ($params['action'] == "edit") {
			if ($data['name'] != $data['currentName']) {
				$this->Applications->rename($data["currentName"], $data["name"]);
			}
		}

		if ($params['action'] == "add") {
			$applications = $this->Applications->getList();
			if (in_array($data['name'], $applications)) {
				$this->Flash->error(__('The table ' . $data['name'] . ' already exists.'), ['plugin' => 'Rhino']);
				return;
			}

			$this->Applications->create($data["name"]);
		}

		return $data;
	}

	public function newGroup() {
        if ($this->request->is(['patch', 'post', 'put'])) {
			$entry = $this->Groups->newEmptyEntity();
            $group = $this->Groups->patchEntity($entry, $this->request->getData());
            
			if ($this->Groups->save($group)) {
                $this->Flash->success(__('The table has been saved.'), ['plugin' => 'Rhino']);

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The table could not be saved. Please, try again.'), ['plugin' => 'Rhino']);
        }
	}
	
	public function renameGroup($id) {
		$entry = $this->Groups->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $group = $this->Groups->patchEntity($entry, $this->request->getData());
            
			if ($this->Groups->save($group)) {
                $this->Flash->success(__('The table has been saved.'), ['plugin' => 'Rhino']);

                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The table could not be saved. Please, try again.'), ['plugin' => 'Rhino']);
        }

		$this->set(['entity' => $entry]);
	}

	public function deleteGroup($id) {
		$entry = $this->Groups->get($id);

		if ($this->Groups->delete($entry)) {
            $this->Flash->success(__('The user has been deleted.'), ['plugin' => 'Rhino']);
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'), ['plugin' => 'Rhino']);
        }

        return $this->redirect(['action' => 'index']);
	}

    /**
     * Delete method
     *
     * @param string|null $id Table id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(string $tableName) {
		$entry = $this->Applications->getByName($tableName);
		if ($entry) {
			$this->Applications->delete($entry);
		}
		$this->Applications->drop($tableName);
        return $this->redirect(['action' => 'index']);
    }

	public function createTable() {
		$this->Tables->createTable();
		 return $this->redirect(['action' => 'index']);
	}
}
