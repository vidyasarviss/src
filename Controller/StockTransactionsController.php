<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * StockTransactions Controller
 *
 * @property \App\Model\Table\StockTransactionsTable $StockTransactions
 *
 * @method \App\Model\Entity\StockTransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StockTransactionsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Items', 'Warehouses']
        ];
        $stockTransactions = $this->paginate($this->StockTransactions);

        $this->set(compact('stockTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Stock Transaction id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $stockTransaction = $this->StockTransactions->get($id, [
            'contain' => ['Items', 'Warehouses']
        ]);

        $this->set('stockTransaction', $stockTransaction);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $stockTransaction = $this->StockTransactions->newEntity();
        if ($this->request->is('post')) {
            $stockTransaction = $this->StockTransactions->patchEntity($stockTransaction, $this->request->getData());
            if ($this->StockTransactions->save($stockTransaction)) {
                $this->Flash->success(__('The stock transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transaction could not be saved. Please, try again.'));
        }
        $items = $this->StockTransactions->Items->find('list', ['limit' => 200]);
        $warehouses = $this->StockTransactions->Warehouses->find('list', ['limit' => 200]);
        $this->set(compact('stockTransaction', 'items', 'warehouses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stock Transaction id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $stockTransaction = $this->StockTransactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $stockTransaction = $this->StockTransactions->patchEntity($stockTransaction, $this->request->getData());
            if ($this->StockTransactions->save($stockTransaction)) {
                $this->Flash->success(__('The stock transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stock transaction could not be saved. Please, try again.'));
        }
        $items = $this->StockTransactions->Items->find('list', ['limit' => 200]);
        $warehouses = $this->StockTransactions->Warehouses->find('list', ['limit' => 200]);
        $this->set(compact('stockTransaction', 'items', 'warehouses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stock Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $stockTransaction = $this->StockTransactions->get($id);
        if ($this->StockTransactions->delete($stockTransaction)) {
            $this->Flash->success(__('The stock transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The stock transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
