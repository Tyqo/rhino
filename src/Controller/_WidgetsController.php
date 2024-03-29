<?php
declare(strict_types=1);

namespace Rhino\Controller;

use Rhino\Controller\RhinoController;

/**
 * Widgets Controller
 *
 * @property \Rhino\Model\Table\WidgetsTable $Widgets
 * @method \Rhino\Model\Entity\Widget[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class _WidgetsController extends RhinoController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $widgets = $this->paginate($this->Widgets);

        $this->set(compact('widgets'));
    }

    /**
     * View method
     *
     * @param string|null $id Widget id.
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
    public function add()
    {
        $widget = $this->Widgets->newEmptyEntity();
        if ($this->request->is('post')) {
            $widget = $this->Widgets->patchEntity($widget, $this->request->getData());
            if ($this->Widgets->save($widget)) {
                $this->Flash->success(__('The widget has been saved.'), ['plugin' => 'Rhino']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The widget could not be saved. Please, try again.'), ['plugin' => 'Rhino']);
        }
        $this->set(compact('widget'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Widget id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $widget = $this->Widgets->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $widget = $this->Widgets->patchEntity($widget, $this->request->getData());
            if ($this->Widgets->save($widget)) {
                $this->Flash->success(__('The widget has been saved.'), ['plugin' => 'Rhino']);

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The widget could not be saved. Please, try again.'), ['plugin' => 'Rhino']);
        }
        $this->set(compact('widget'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Widget id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $widget = $this->Widgets->get($id);
        if ($this->Widgets->delete($widget)) {
            $this->Flash->success(__('The widget has been deleted.'), ['plugin' => 'Rhino']);
        } else {
            $this->Flash->error(__('The widget could not be deleted. Please, try again.'), ['plugin' => 'Rhino']);
        }

        return $this->redirect(['action' => 'index']);
    }
}
