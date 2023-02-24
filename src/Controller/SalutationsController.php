<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Salutations Controller
 *
 * @property \App\Model\Table\SalutationsTable $Salutations
 * @method \App\Model\Entity\Salutation[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalutationsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $salutations = $this->paginate($this->Salutations);

        $this->set(compact('salutations'));
    }

    /**
     * View method
     *
     * @param string|null $id Salutation id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salutation = $this->Salutations->get($id, [
            'contain' => ['customers'],
        ]);

        $this->set(compact('salutation'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salutation = $this->Salutations->newEmptyEntity();
        if ($this->request->is('post')) {
            $salutation = $this->Salutations->patchEntity($salutation, $this->request->getData());
            if ($this->Salutations->save($salutation)) {
                $this->Flash->success(__('The salutation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salutation could not be saved. Please, try again.'));
        }
        $this->set(compact('salutation'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Salutation id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salutation = $this->Salutations->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salutation = $this->Salutations->patchEntity($salutation, $this->request->getData());
            if ($this->Salutations->save($salutation)) {
                $this->Flash->success(__('The salutation has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The salutation could not be saved. Please, try again.'));
        }
        $this->set(compact('salutation'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Salutation id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salutation = $this->Salutations->get($id);
        if ($this->Salutations->delete($salutation)) {
            $this->Flash->success(__('The salutation has been deleted.'));
        } else {
            $this->Flash->error(__('The salutation could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
