<?php
use Setasign\Fpdf;
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
 * PurchaseOrders Controller
 *
 * @property \App\Model\Table\PurchaseOrdersTable $PurchaseOrders
 *
 * @method \App\Model\Entity\PurchaseOrder[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseOrdersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
  
        $this->paginate = [
            'contain' => ['Suppliers']
        ];
        $this->paginate['order']=['id'=>'DESC'];
        $purchaseOrders = $this->paginate($this->PurchaseOrders);

        $this->set(compact('purchaseOrders'));
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
        $purchaseOrder = $this->PurchaseOrders->get($id, [
            'contain' => ['Suppliers', 'PurchaseOrderItems']
        ]);
        foreach ($purchaseOrder->purchase_order_items as $purchaseOrderItems)
        {
            $items = TableRegistry::get('Items');      
	    	$purchaseOrderItems->purchaseOrder_id=$purchaseOrder->id;
        	$purchaseOrderItems->item_name = $items->get($purchaseOrderItems->item_id)->item_name;
        	
        	$units= TableRegistry::get('Units');
        	$purchaseOrderItems->purchaseOrder_id=$purchaseOrder->id;
			$purchaseOrderItems->unit_name=$units->get($purchaseOrderItems->unit_id)->name; 
			
			$warehouses = TableRegistry::get('Warehouses');  
			$purchaseOrderItems->purchaseOrder_id=$purchaseOrder->id;
			$purchaseOrderItems->warehouse_name=$warehouses->get($purchaseOrderItems->warehouse_id)->name;
	    }
	    
        $this->set('purchaseOrder', $purchaseOrder);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->request->getData();
        $purchaseOrder = $this->PurchaseOrders->newEntity();
        if ($this->request->is('post')) {
            $purchaseOrder = $this->PurchaseOrders->patchEntity($purchaseOrder, $this->request->getData());
            if ($this->PurchaseOrders->save($purchaseOrder)) {
            $po_table=TableRegistry::get('Purchase_order_items'); 
                $i = 0;
                //debug($data);die();    
                foreach($data['items'] as $item)
                {
	                $purchase_order_item=$po_table->newEntity();
                    $purchase_order_item->item_id= $item;
                    $purchase_order_item->purchase_order_id=$purchaseOrder->id;
                    $purchase_order_item->unit_id= $data['units'][$i];	 
                    $purchase_order_item->quantity= $data['qty'][$i];
                    $purchase_order_item->rate= $data['rate'][$i];
                    //$purchase_order_item->amount= $data['amount'][$i];
                    $purchase_order_item->warehouse_id= $data['warehouses'][$i];
	                $status=$po_table->save($purchase_order_item);
	         	//$st_table=TableRegistry::get('stockTransactions');
	         	//this is for stock transaction adding
                if($status)
                {
                    $st_table=TableRegistry::get('stockTransactions');
                    $pt=$st_table->newEntity();
                    $pt->item_id= $item;
                    $pt->purchase_order_id=$purchaseOrder->id;
                    $pt->unit_id= $data['units'][$i];
                    $pt->quantity= $data['qty'][$i];
                    $pt->rate= $data['rate'][$i];
                    $pt->type=2;
                    $pt->transaction_date=$purchaseOrder->transaction_date;
                    //$purchase_order_item->amount= $data['amount'][$i];
                    $pt->warehouse_id= $data['warehouses'][$i];
                    $pt->referenceid=$purchaseOrder->id;
                    $st_table->save($pt);
                    $i++;
                }	        
                }
                $this->Flash->success(__('The purchase order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            //debug($purchase_order->errors());die();
            $units = TableRegistry::get('Units');
            $this->set('units',$units->find('list'));
            
             $items = TableRegistry::get('Items');
            $this->set('items',$items->find('list'));
            
            $warehouses = TableRegistry::get('Warehouses');
            $this->set('warehouses',$warehouses->find('list'));
           
            $this->Flash->error(__('The purchase order could not be saved. Please, try again.'));
        }
        else if($this->request->is('get')){
            $units = TableRegistry::get('Units');
            
            $this->set('units',$units->find('list'));
            $items = TableRegistry::get('Items');
            $this->set('items',$items->find('list'));
            
            $warehouses = TableRegistry::get('Warehouses');
            $this->set('warehouses',$warehouses->find('list'));
           
            }
        $suppliers = $this->PurchaseOrders->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrder', 'suppliers'));
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
    	$data = $this->request->getData();
    	$purchaseOrder = $this->PurchaseOrders->newEntity();
        $purchaseOrder = $this->PurchaseOrders->get($id, [
            'contain' => ['PurchaseOrderItems']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) 
        {   
            //debug($data);die();
            $purchaseOrder = $this->PurchaseOrders->patchEntity($purchaseOrder, $this->request->getData());
            //debug($this->request->getData());die();
            if ($this->PurchaseOrders->save($purchaseOrder)) 
            {
            $st_table=TableRegistry::get('stockTransactions');
            $po_table=TableRegistry::get('Purchase_order_items');
                 $items=TableRegistry::get('Items'); 
                 $i = 0;                             
                 foreach($data['items'] as $item)
                 {                	
                 	$purchase_order_item = $po_table->find('all')->where(['item_id'=>$item,'purchase_order_id'=>$id])->first();
                 	if($purchase_order_item)
                 	{
                 	    //debug($item);die();
                 	    $purchase_order_item->item_id= $item;
                        $purchase_order_item->unit_id= $data['units'][$i]; 
                 	    $purchase_order_item->quantity= $data['qty'][$i];
			    		$purchase_order_item->rate= $data['rate'][$i]; 
			    		$purchase_order_item->warehouse_id= $data['warehouses'][$i]; 
			    		//$purchase_order_item->amount= $data['amount'][$i]; 
			    		$status=$po_table->save($purchase_order_item);
			    		if($status)
			    		{
			    		    $pt=$st_table->find('all')->where(['item_id'=>$item,'referenceid'=>$id])->first();
			    		    // $pt=$st_table->newEntity();
			    		    $pt->item_id= $item;
			    		    $pt->purchase_order_id=$purchaseOrder->id;
			    		    $pt->unit_id= $data['units'][$i];
			    		    $pt->quantity= $data['qty'][$i];
			    		    $pt->rate= $data['rate'][$i];
			    		    //$purchase_order_item->amount= $data['amount'][$i];
			    		    $pt->warehouse_id= $data['warehouses'][$i];
			    		    $pt->type=2;
			    		    $pt->transaction_date=$purchaseOrder->transaction_date;
			    		    $pt->referenceid=$purchaseOrder->id;
			    		    $st_table->save($pt);
			    		}
                 	}else{
                 	    $purchase_order_item = $po_table->newEntity();
                 	    $purchase_order_item->purchase_order_id=$purchaseOrder->id;
                 	    $purchase_order_item->item_id= $item;
                 	    $purchase_order_item->unit_id= $data['units'][$i];
                 	    $purchase_order_item->quantity= $data['qty'][$i];
                 	    $purchase_order_item->rate= $data['rate'][$i];
                 	    $purchase_order_item->warehouse_id= $data['warehouses'][$i];
                 	    //$purchase_order_item->amount= $data['amount'][$i];
                 	    $status=$po_table->save($purchase_order_item);
                 	    
                 	    
                 	    //This is for stockt_transaction edit
                 	    //debug($purchase_order_item);die();
                 	    //$purchase_order_item = $po_table->find('all')->where(['item_id'=>$item,'purchase_order_id'=>$id])->first();
                 	    if($status)
                 	    {
                 	        //$st_table=TableRegistry::get('stockTransactions');
                 	        $pt=$st_table->newEntity();
                 	        $pt->item_id= $item;
                 	        $pt->purchase_order_id=$purchaseOrder->id;
                 	        $pt->unit_id= $data['units'][$i];
                 	        $pt->quantity= $data['qty'][$i];
                 	        $pt->rate= $data['rate'][$i];
                 	        //$purchase_order_item->amount= $data['amount'][$i];
                 	        $pt->warehouse_id= $data['warehouses'][$i];
                 	        $pt->type=2;
                 	        $pt->transaction_date=$purchaseOrder->transaction_date;
                 	        $pt->referenceid=$purchaseOrder->id;
                 	        
                 	        $st_table->save($pt);
                 	    }
                 	}
                 	$i++;
                 }
                
                $this->Flash->success(__('The purchase order has been saved.'));
                 
                return $this->redirect(['action' => 'index']);
          }
            
                $units = TableRegistry::get('Units');
                $this->set('units',$units->find('list'));
             
                $items = TableRegistry::get('Items');
                $this->set('items',$items->find('list'));
             
                $warehouses = TableRegistry::get('Warehouses');
                $this->set('warehouses',$warehouses->find('list'));
            
                $this->Flash->error(__('The purchase order could not be saved. Please, try again.'));
        }
        
         else if($this->request->is('get')){
             $units = TableRegistry::get('Units');
             $this->set('units',$units->find('list'));
             
             $items = TableRegistry::get('Items');
             $this->set('items',$items->find('list'));
             
             $warehouses = TableRegistry::get('Warehouses');
             $this->set('warehouses',$warehouses->find('list'));
             }
        
        $suppliers = $this->PurchaseOrders->Suppliers->find('list', ['limit' => 200]);
        $this->set(compact('purchaseOrder', 'suppliers'));
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
        $purchaseOrder = $this->PurchaseOrders->get($id);
        if ($this->PurchaseOrders->delete($purchaseOrder))
        {
            $this->Flash->success(__('The purchase order has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase order could not be deleted. Please, try again.'));
                }

        return $this->redirect(['action' => 'index']);
    }
    
    
 public function getunits()
  {
    $this->RequestHandler->respondAs('json');
    $this->response->type('application/json');
    $this->autoRender = false ;      
      
    $itemid = $this->request->query();
    $items_table = TableRegistry::get('Items');
    $item = $items_table ->get($itemid['itemid']);
    $units_table = TableRegistry::get('Units');
   
    $units=$units_table->find('list')->where(['id IN '=>[$item->purchase_unit,$item->sell_unit,$item->usage_unit]]);
    
    $this->RequestHandler->renderAs($this, 'json');

    $resultJ=json_encode($units);
    $this->response->type('json');
    $this->response->body($resultJ);
    return $this->response;
    
  }
 public function getitems()
  {
  $this->RequestHandler->respondAs('json');
  $this->response->type('application/json');
  $this->autoRender = false ;
  $array=$this->request->data();
  //debug($array);die();
  $pid=$array;
  $this->set('pid',$pid);
  $Purchase_order_items_table = TableRegistry::get('Purchase_order_items');
 	 foreach($pid['purchase_order_itemid'] as $id)
  	{
      $pstatus = $Purchase_order_items_table->get($id);
      $status=$Purchase_order_items_table->delete($pstatus);
      if($status)
      {  
          $st_table=TableRegistry::get('stock_transactions');
          $stck = $st_table->find('all')->where(['item_id'=>$pstatus->item_id,'referenceid'=>$pstatus->purchase_order_id])->first();
          //debug($stck);die();
          $status=$st_table->delete($stck);
          if($status)
             {
              $status=true;
             }else{
                    $status=false;
                    break;
                   }
         
       }else{
              $status=false;
              break;
            }
     }
     
  $this->RequestHandler->renderAs($this,'json');
  
  $resultJ=json_encode($pstatus);
  $this->response->type('json');
  $this->response->body($resultJ);
  return $this->response;
 }
 public function generatepdf()
 {
     $this->RequestHandler->respondAs('json');
     $this->response->type('application/json');
     $this->autoRender = false ;
     $id = $this->request->query()['id'];
     $po_table = TableRegistry::get('PurchaseOrders');
     $po = $po_table->get($id, [
         'contain' => ['PurchaseOrderItems']
     ]);
     
     $width_cell=array(20,40,20,20,20,50,20);
     $width_cell1=array(50,240);
     
     
     $sp_table = TableRegistry::get('suppliers');
     $supplier = $sp_table->get($po->supplier_id);
     //debug($supplier);die();
     $po->supplier_name = $supplier->name;
     
     $pdf = new \FPDF();
     $pdf->AddPage();
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(130,20,'Purchase order report',0,4,'R');
     $pdf->SetFont('Arial','B',14);
     
     $pdf->Cell($width_cell1[0],10,'Supplier Name:',0,0,'L',false); 
     $pdf->Cell($width_cell1[1],10,$po->supplier_name,0,1,'C',false); 
     
     $pdf->Cell($width_cell1[0],10,'Transaction date:',0,0,'L',false); 
     $pdf->Cell($width_cell1[1],10,$po->transaction_date,0,1,'C',false); 
     
     $pdf->Cell($width_cell1[0],10,'Required date:',0,0,'L',false); 
     $pdf->Cell($width_cell1[1],10,$po->required_date,0,1,'C',false); 
     
     $pdf->SetFont('Arial','B',16);
     $pdf->Cell(130,20,'Related purchase Order Items',0,4,'R');
     $pdf->SetFont('Arial','B',12);
     $pdf->Cell($width_cell[0],10,'Id',1,0,'C',false); //1 column of row 1 
     $pdf->Cell($width_cell[1],10,'Item',1,0,'C',false);//2 column of row 1 
     $pdf->Cell($width_cell[2],10,'Unit',1,0,'C',false);//3 column of row 1
     $pdf->Cell($width_cell[3],10,'Quantity',1,0,'C',false);//4 column of row 1
     $pdf->Cell($width_cell[4],10,'Rate',1,0,'C',false);//5 column of row 1
     $pdf->Cell($width_cell[6],10,'Amount',1,0,'C',false);//6 column of row 1
     $pdf->Cell($width_cell[5],10,'Warehouse',1,1,'C',false);//7 column of row 1 and use 1 to break the line n conti..2row
     
    // $pdf->Cell($width_cell[1],10,'John Deo',1,0,'C',false);
     $i=0;
     foreach ($po->purchase_order_items as $purchaseOrderItem)
     {    $pdf->SetFont('Arial','',12);
         $qty=$purchaseOrderItem->quantity;
         $rate=$purchaseOrderItem->rate;
         $amount=$qty*$rate;
         
         $items = TableRegistry::get('Items');
         $purchaseOrderItem->purchaseOrder_id=$po->id;
         $purchaseOrderItem->item_name = $items->get($purchaseOrderItem->item_id)->item_name;
         
         $units= TableRegistry::get('Units');
         $purchaseOrderItem->purchaseOrder_id=$po->id;
         $purchaseOrderItem->unit_name=$units->get($purchaseOrderItem->unit_id)->name;
         
         $warehouses = TableRegistry::get('Warehouses');
         $purchaseOrderItem->purchaseOrder_id=$po->id;
         $purchaseOrderItem->warehouse_name=$warehouses->get($purchaseOrderItem->warehouse_id)->name;
         
         $pdf->Cell($width_cell[0],10,$purchaseOrderItem->id,1,0,'C',false);
         $pdf->Cell($width_cell[1],10,$purchaseOrderItem->item_name,1,0,'C',false);
         $pdf->Cell($width_cell[2],10,$purchaseOrderItem->unit_name,1,0,'C',false);
         $pdf->Cell($width_cell[3],10,$purchaseOrderItem->quantity,1,0,'C',false);
         $pdf->Cell($width_cell[4],10,$purchaseOrderItem->rate,1,0,'C',false);
         $pdf->Cell($width_cell[6],10,$amount,1,0,'C',false);
         $pdf->Cell($width_cell[5],10,$purchaseOrderItem->warehouse_name,1,1,'C',false);
         
         $i++;
         
     }
     
     $pdf->Output();
     exit;
     
     
 }
 
 
}
