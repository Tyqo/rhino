<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\RhinoController;

/**
 * Widgets Controller
 *
 * @property \Rhino\Model\Table\WidgetsTable $Widgets
 */
class WidgetsController extends RhinoController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Widgets->find();
        $widgets = $this->paginate($query);

        $this->set(compact('widgets'));
    }

    /**
     * View method
     *
     * @param string|null $id Rhino Widget id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $widget = $this->Widgets->get($id, contain: []);
        $this->set(compact('widget'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(?int $widget_category_id = null)
    {
        $widget = $this->Widgets->newEmptyEntity();

		$widget->widget_category_id = $widget_category_id;

        $this->compose($widget, [
			'entity' => 'widget',
			"redirect" => ['controller' => 'WidgetCategories', 'action' => 'view', $widget_category_id],
			'success' => __('The widget category has been saved.'),
			'error' => __('The widget category could not be saved. Please, try again.')
		]);
    }

    /**
     * Edit method
     *
     * @param string|null $id Rhino Widget id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $widget = $this->Widgets->get($id, contain: []);
		$widget_category_id = $widget->widget_category_id;
		$this->compose($widget, [
			'entity' => 'widget',
			"redirect" => ['controller' => 'WidgetCategories', 'action' => 'view', $widget_category_id],
			'success' => __('The widget category has been saved.'),
			'error' => __('The widget category could not be saved. Please, try again.')
		]);
    }

	public function preCompose(object $widget, mixed ...$params) {
		$widgetCategories = $this->Widgets->WidgetCategories->find('list', limit: 200)->all();
        $this->set(compact('widgetCategories'));
		return $widget;
	}

    /**
     * Delete method
     *
     * @param string|null $id Rhino Widget id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $widget = $this->Widgets->get($id);
        if ($this->Widgets->delete($widget)) {
            $this->Flash->success(__('The rhino widget has been deleted.'));
        } else {
            $this->Flash->error(__('The rhino widget could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
