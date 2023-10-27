<?php
declare(strict_types=1);

namespace Tusk\Controller;

use Tusk\Controller\AppController;
use InvalidArgumentException;
/**
 * Tables Controller
 *
 * @method \Tusk\Model\Entity\Table[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TablesController extends AppController
{
	public function initialize(): void {
		parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function list() {
        $tables = $this->Tables->getList();
        $this->set(compact('tables'));
    }

    /**
     * View method
     *
     * @param string|null $id Table id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function index($tableName = null) {
        $this->setTable($tableName);
		$columns = $this->FieldHandler->listColumns($tableName);

		$data = $this->paginateFilter($this->Table->find("all"));

        $this->set([
			'data' => $data,
			'columns' => $columns,
			'tableName' => $tableName
		]);
    }

	/**
	 * Add method
	 *
	 * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
	 */
	public function add($tableName = null) {
		$this->setTable($tableName);
		$entry = $this->Table->newEmptyEntity();
		$this->set(['title' => 'Add']);
		$this->compose($entry, ["redirect" => ['action' => 'index', $tableName]]);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Table id.
	 * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($tableName = null, $id = null) {
		$this->setTable($tableName);
		$entry = $this->Table->get($id);
		$this->set(['title' => 'Edit']);
		$this->compose($entry, ["redirect" => ['action' => 'index', $tableName]]);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Table id.
	 * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($tableName = null, $id = null) {
		$this->setTable($tableName);
		$entry = $this->Table->get($id);
		$this->set(['title' => 'View', 'readonly' => true]);
		$this->compose($entry, ["redirect" => ['action' => 'index', $tableName]]);
	}


	public function preSave($data, $params) {
		if ($params['action'] == "view") {
			$this->Flash->warning('A View can not be saved.');
		}
		return $data;
	}


	/**
	 * Delete method
	 *
	 * @param string|null $id Table id.
	 * @return \Cake\Http\Response|null|void Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($tableName = null, $id = null) {
		$this->setTable($tableName);
		$this->request->allowMethod(['post', 'delete']);
		$entry = $this->Table->get($id);
		if ($this->Table->delete($entry)) {
			$this->Flash->success(__('The table has been deleted.'), ['plugin' => 'Tusk']);
		} else {
			$this->Flash->error(__('The table could not be deleted. Please, try again.'), ['plugin' => 'Tusk']);
		}

		return $this->redirect(['action' => 'index', $tableName]);
	}

	public function export($tableName) {
		$this->setTable($tableName);
		$data = $this->Table->find();
		$header = $this->FieldHandler->listColumns($tableName);

		$delimiter = ';';
		$enclosure = '"';
		$newline = '\r\n';

		$this->set(compact('data'));
		$this->viewBuilder()
			->setClassName('CsvView.Csv')
			->setOptions([
				'serialize' => 'data',
				'header' => $header,
				'delimiter' => $delimiter,
				'enclosure' => $enclosure,
				'newline' => $newline
			]);

	}
}
