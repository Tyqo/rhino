<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\AppController;

/**
 * MediaCategories Controller
 *
 * @property \Rhino\Model\Table\MediaCategoriesTable $mediaCategories
 */
class MediaCategoriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $mediaCategories = $this->MediaCategories->find();
        // $mediaCategories = $this->paginate($query);
        $this->set(compact('mediaCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Rhino Media Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $mediaCategory = $this->MediaCategories->get($id, contain: ['Media' => ['sort' => ['Media.position' => 'ASC']]]);
        $this->set(compact('mediaCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $mediaCategory = $this->MediaCategories->newEmptyEntity();
       	$this->compose($mediaCategory, [
			"redirect" => ['action' => 'index'],
			'success' => __('TThe media category has been saved.'),
			'error' => __('The media category could not be saved. Please, try again.')
		]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rhino Media Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $mediaCategory = $this->MediaCategories->get($id, contain: []);
		$this->compose($mediaCategory, [
			"redirect" => ['action' => 'index'],
			'success' => __('TThe media category has been saved.'),
			'error' => __('The media category could not be saved. Please, try again.')
		]);
    }

	
	public function preCompose($mediaCategory) {
		return $mediaCategory;
	}


    /**
     * Delete method
     *
     * @param string|null $id Rhino Media Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $mediaCategory = $this->MediaCategories->get($id);
        if ($this->MediaCategories->delete($mediaCategory)) {
            $this->Flash->success(__('The rhino media category has been deleted.'));
        } else {
            $this->Flash->error(__('The rhino media category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
