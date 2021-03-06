<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrder $purchaseOrder
 */
?>

<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Order'), ['action' => 'edit', $purchaseOrder->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Order'), ['action' => 'delete', $purchaseOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrder->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Items'), ['controller' => 'PurchaseOrderItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Item'), ['controller' => 'PurchaseOrderItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrders view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrder->id) ?></h3>
   <button type="print"  value="submit" onclick="pdf_print()"> Print </button>
   <input type="hidden" value="<?php echo $purchaseOrder->id; ?>" id="poid">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $purchaseOrder->has('supplier') ? $this->Html->link($purchaseOrder->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $purchaseOrder->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrder->id) ?></td>
        </tr>
       
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($purchaseOrder->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Required Date') ?></th>
            <td><?= h($purchaseOrder->required_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Purchase Order Items') ?></h4>
        <?php if (!empty($purchaseOrder->purchase_order_items)): ?>
        <table  cellpadding="0" cellspacing="0" id='viewTable' >
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Warehouse Id') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
            </tr>
            
            <?php 
            $index = 1;
            foreach ($purchaseOrder->purchase_order_items as $purchaseOrderItems):
            $quantity = 'quantity_id'.$index;
            $rate = 'rate_id'.$index;
            $amount = 'amount_id'.$index;
            ?>
            
            <tr>
                <td><?= h($purchaseOrderItems->id) ?></td>
                <td><?= h($purchaseOrderItems->item_name) ?></td>
                <td><?= h($purchaseOrderItems->unit_name) ?></td>
                <td id="<?php echo $quantity; ?>"><?= h($purchaseOrderItems->quantity) ?></td>
                <td id="<?php echo $rate; ?>"><?= h($purchaseOrderItems->rate) ?></td>
                <td><?= h($purchaseOrderItems->warehouse_name) ?></td>
                <td id="<?php echo $amount; ?>"><?= h($purchaseOrderItems->amount) ?></td>
            </tr>
            
            <?php
            $index++;
            ?>
            
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
<script src="/js/jquery-3.3.1.min.js"> </script>
 <script>
 
 	function do_onload()
 	{
        var poCount = $('#viewTable tr').length;
        console.log('afasfasf111111 ', poCount);        
        for(var i=1; i<poCount;i++){
            console.log("iiiiii ", $('#quantity'+i));
            var qty = $('#quantity_id'+i).text();
			var rate = $('#rate_id'+i).text();
			var amount = parseFloat(qty) * parseFloat(rate);
			$('#amount_id'+i).text(amount);
            console.log(amount,qty,rate);            
		}
	}
		
		window.onload = do_onload();
	
	function pdf_print()
	{
	var poid = $('#poid').val();
	window.open("http://localhost:8765/purchase-orders/generatepdf?id="+poid);
	
	}
	
 </script>
