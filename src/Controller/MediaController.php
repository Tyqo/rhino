<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\AppController;

/**
 * Media Controller
 *
 * @property \Rhino\Model\Table\MediaTable $media
 */
class MediaController extends AppController {

	public function initialize(): void {
        parent::initialize();

		$this->fieldConfig = [
			'filename' => [
				'type' => 'upload',
				'options' =>  [
					'uploadDirectory' => 'test/',
					'uploadTypes' => '',
					'uploadOverwrite' => '',
					'uploadMultiple' => ''
				]
			]
		];
	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $query = $this->Media->find()
            ->contain(['MediaCategories']);
        $media = $this->paginate($query);

        $this->set(compact('media'));
    }

    /**
     * View method
     *
     * @param string|null $id Rhino Media id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $media = $this->Media->get($id, contain: ['MediaCategories']);
        $this->set(compact('media'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($categoryId = null) {
        $media = $this->Media->newEmptyEntity();
		$media->media_category_id = $categoryId;
		$this->compose($media, [
			"redirect" => ['controller' => 'MediaCategories', 'action' => 'view', $media->media_category_id],
			'success' => __('The media has been saved.'),
			'error' => __('The media could not be saved. Please, try again.')
		]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rhino Media id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $media = $this->Media->get($id, contain: []);
		$this->compose($media, [
			"redirect" => ['controller' => 'MediaCategories', 'action' => 'view', $media->media_category_id],
			'success' => __('TThe media has been saved.'),
			'error' => __('The media could not be saved. Please, try again.')
		]);
    }

	public function preCompose($media) {
		$mediaCategories = $this->Media->MediaCategories->find('list', limit: 200)->all();
        $this->set(compact('mediaCategories'));
		return $media;
	}

	public function preSave($media) {
		// dd($media);
		return $media;
	}

    /**
     * Delete method
     *
     * @param string|null $id Rhino Media id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $media = $this->Media->get($id);
        if ($this->Media->delete($media)) {
            $this->Flash->success(__('The media has been deleted.'));
        } else {
            $this->Flash->error(__('The media could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}