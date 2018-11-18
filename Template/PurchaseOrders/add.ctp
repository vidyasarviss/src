<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrder $purchaseOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Order Items'), ['controller' => 'PurchaseOrderItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Order Item'), ['controller' => 'PurchaseOrderItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseOrders form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseOrder) ?>
    <fieldset>
        <legend><?= __('Add Purchase Order') ?></legend>
        <?php
            echo $this->Form->control('supplier_id', ['options' => $suppliers, 'empty' => true]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('required_date');
        ?>
    </fieldset>
    
    <table id="purchase_ordersTable">
    <tr>
    <td><?php echo $this->Form->control('item_id',array('type'=>'select','options'=>$items, 'name'=>'items[]','onchange'=>'change(this)'));?></td>
    <td><?php echo $this->Form->control('unit_id',array('type'=>'select','options'=>$units, 'name'=>'units[]')); ?></td>
    <td><?php echo $this->Form->control('quantity', array('name'=>'qty[]','required'=>'true')); ?></td>
    <td><?php echo $this->Form->control('rate'); ?></td>
    <td><?php echo $this->Form->control('warehouse_id',array('type'=>'select','options'=>$warehouses, 'name'=>'warehouses[]')); ?></td>
    <td><?php echo $this->Form->control('amount'); ?></td>
    </tr>
    <input type="button" onclick="add_row()" value="Add row" > 
    
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
<script>
    var item_select_box=document.getElementById('item-id');
    window.onload=change(item_select_box);
    function add_row() {
 	var units = <?php echo json_encode($units)?>;
	var unit_options = "";
	for(var k in units)
	{
	unit_options+= "<option value=' "+ k +" '>" +units[k]+ "</option>";
	}
	var items = <?php echo json_encode($items) ?>;
	var item_options = "";
	for(var k in items)
	{
	item_options+= "<option value=' "+ k +" '>" +items[k]+ "</option>";
	}
	var table = document.getElementById("purchase_ordersTable");
    var no_of_rows=$('#purchase_ordersTable tr').length;
    var row = table.insertRow().innerHTML = '<tr>\
     <td><select name="items[]" onchange="change(this)" id=item-id'+(no_of_rows)+'>'+item_options+'</select></td>\
    <td><?php echo $this->Form->control(' ', array('name'=>'qty[]')); ?></td>\
    <td><select name="units[]" id=unit-id'+(no_of_rows)'+unit_options+'</select></td>\
    </tr>';
    }
	</script>