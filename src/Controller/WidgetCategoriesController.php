<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\RhinoController;

/**
 * WidgetCategories Controller
 *
 * @property \Rhino\Model\Table\WidgetCategoriesTable $WidgetCategories
 */
class WidgetCategoriesController extends RhinoController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index() {
        $widgetCategories = $this->WidgetCategories->find();
        // $widgetCategories = $this->paginate($query);
        $this->set(compact('widgetCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Rhino Widget Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $widgetCategory = $this->WidgetCategories->get($id, contain: ['Widgets' => ['sort' => ['Widgets.position' => 'ASC']]]);
        $this->set(compact('widgetCategory'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $widgetCategory = $this->WidgetCategories->newEmptyEntity();;
		$this->compose($widgetCategory, [
			'entity' => 'widgetCategory',
			"redirect" => ['action' => 'index'],
			'success' => __('The widget category has been saved.'),
			'error' => __('The widget category could not be saved. Please, try again.')
		]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rhino Widget Category id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) {
        $widgetCategory = $this->WidgetCategories->get($id, contain: []);
      	$this->compose($widgetCategory, [
			'entity' => 'widgetCategory',
			"redirect" => ['action' => 'index'],
			'success' => __('The widget category has been saved.'),
			'error' => __('The widget category could not be saved. Please, try again.')
		]);
    }


    /**
     * Delete method
     *
     * @param string|null $id Rhino Widget Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $widgetCategory = $this->WidgetCategories->get($id);
        if ($this->WidgetCategories->delete($widgetCategory)) {
            $this->Flash->success(__('The widget category has been deleted.'));
        } else {
            $this->Flash->error(__('The widget category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
