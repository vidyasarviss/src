<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;

use App\Form\PurchaseOrdersReportForm;
class PurchaseOrdersReportController extends AppController
{
    public function index()
    {
       
//      debug($data);die();
        $po_table=TableRegistry::get('Purchase_orders');
        $poi_table=TableRegistry::get('PurchaseOrderItems');

        $def_date = date("Y-m-d");
        //debug($def_date);die();
        $items_table = TableRegistry::get('Items');
        $item=$items_table->find('list');
        $this->set('items',$item);
        
        
        $warehouse_table = TableRegistry::get('Warehouses');
        $warehouse=$warehouse_table->find('list');
        $this->set('warehouses',$warehouse);
        
        
        $data = $this->request->query();

        if(!empty($data))
        {
            $conditions = array();
            
            if(!is_null($data['item_id']))
           {
               array_push($conditions,array('item_id'=>$data['item_id']));
           }
        if(!is_null($data['warehouse_id']))
          {
            array_push($conditions,array('warehouse_id'=>$data['warehouse_id']));
          }
          
          $pos = $poi_table->find('all', array('fields' => array('po.id','po.transaction_date','po.required_date', 'warehouse_id', 'item_id', 'quantity', 'rate', 'Items.item_name', 'Warehouses.name')))->join([
              'po' => [
                  'table' => 'purchase_orders',
                  'type' => 'INNER',
                  'conditions' => 'PurchaseOrderItems.purchase_order_id = po.id'
                  
              ]])->contain(['Items', 'Units', 'Warehouses'])->where($conditions);
          
     //debug($pos->first());die();
        }
        else{
            $pos = $po_table->find('all')->contain(['PurchaseOrderItems', 'PurchaseOrderItems.Items', 'PurchaseOrderItems.Units', 'PurchaseOrderItems.Warehouses']);
       // debug($pos->first());die();
      }
        $this->set('def_date', $def_date);
        $this->set('pos', $pos);
        //$this->set('pois', $pois);
        
    }
    
   
}
