<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\RhinoController;

/**
 * Nodes Controller
 *
 * @property \Rhino\Model\Table\NodesTable $Nodes
 */
class NodesController extends RhinoController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $nodes = $this->Nodes->find('threaded')->where([])->orderBy(["lft" => 'ASC']);
        $this->set(compact('nodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Node Tree id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $nodeTree = $this->Nodes->get($id, contain: ['ParentNodeTree', 'ChildNodeTree']);
        $this->set(compact('nodeTree'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		$nodeTree = $this->Nodes->newEmptyEntity();
		$this->compose($nodeTree, [
			'entity' => 'nodeTree',
			'success' => __('The page has been saved.'),
			'error' => __('The page could not be saved. Please, try again.')
		]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Node Tree id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(int $id) {
        $nodeTree = $this->Nodes->get($id, contain: []);
      	$this->compose($nodeTree, [
			'entity' => 'nodeTree',
			'success' => __('The page has been saved.'),
			'error' => __('The page could not be saved. Please, try again.')
		]);
    }

    /**
     * Delete method
     *
     * @param string|null $id Node Tree id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(int $id)
    {
        $this->request->allowMethod(['post', 'delete']);
        $nodeTree = $this->Nodes->get($id);
        if ($this->Nodes->delete($nodeTree)) {
            $this->Flash->success(__('The node tree has been deleted.'));
        } else {
            $this->Flash->error(__('The node tree could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

	public function preCompose($entry, ...$params) {
		$templates = $this->Nodes->Templates->find('list')->all();
		
		$nodes = $this->Nodes->find('treeList', [
			'spacer' => str_repeat("&nbsp", 3)
		])->all();
		
		$nodes = $this->Nodes->root + $nodes->toArray();
		$roles = $this->Nodes->roles;

		$this->set([
			'nodes' => $nodes,
			'roles' => $roles,
			'templates' => $templates,
			"nodeTypes" => $this->Nodes->nodeTypes
		]);
	}

	public function preSave($data, $params) {
		if ($params['action'] == 'add') {
			$data['user_id'] = $this->user->id;
		}

		return $data;
	}

	public function moveUp($id = null) {
		// $this->request->allowMethod(['post', 'put']);
		$node = $this->Nodes->get($id);
		if ($this->Nodes->moveUp($node)) {
			$this->Flash->success('The category has been moved Up.');
		} else {
			$this->Flash->error('The category could not be moved up. Please, try again.');
		}
		return $this->redirect($this->referer(['action' => 'index']));
	}

	public function moveDown($id = null) {
		// $this->request->allowMethod(['post', 'put']);
		$node = $this->Nodes->get($id);
		if ($this->Nodes->moveDown($node)) {
			$this->Flash->success('The category has been moved down.');
		} else {
			$this->Flash->error('The category could not be moved down. Please, try again.');
		}
		return $this->redirect($this->referer(['action' => 'index']));
	}
}
