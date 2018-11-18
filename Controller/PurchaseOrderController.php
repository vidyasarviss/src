<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PurchaseOrder Controller
 *
 * @property \App\Model\Table\PurchaseOrderTable $PurchaseOrder
 *
 * @method \App\Model\Entity\PurchaseOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseOrderController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $purchaseOrder = $this->paginate($this->PurchaseOrder);

        $this->set(compact('purchaseOrder'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Order id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseOrder = $this->PurchaseOrder->get($id, [
            'contain' => ['Items']
        ]);

        $this->set('purchaseOrder', $purchaseOrder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchaseOrder = $this->PurchaseOrder->newEntity();
        if ($this->request->is('post')) {
            $purchaseOrder = $this->PurchaseOrder->patchEntity($purchaseOrder, $this->request->getData());
            if ($this->PurchaseOrder->save($purchaseOrder)) {
                $this->Flash->success(__('The purchase order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase order could not be saved. Please, try again.'));
        }
        $items = $this->PurchaseOrder->Items->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrder', 'items'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Order id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchaseOrder = $this->PurchaseOrder->get($id, [
            'contain' => ['Items']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseOrder = $this->PurchaseOrder->patchEntity($purchaseOrder, $this->request->getData());
            if ($this->PurchaseOrder->save($purchaseOrder)) {
                $this->Flash->success(__('The purchase order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase order could not be saved. Please, try again.'));
        }
        $items = $this->PurchaseOrder->Items->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrder', 'items'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseOrder = $this->PurchaseOrder->get($id);
        if ($this->PurchaseOrder->delete($purchaseOrder)) {
            $this->Flash->success(__('The purchase order has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
