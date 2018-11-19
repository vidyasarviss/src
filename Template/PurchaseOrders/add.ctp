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
            echo $this->Form->control('supplier_id', ['options' => $suppliers,'required'=>'true','empty' => true]);
            $this->Form->templates(['dateWidget'=>'{{day}}{{month}}{{year}}']);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('required_date');
        ?>
    </fieldset>
    
    <table id="purchase_ordersTable">
    	<tr>
    		<td><?php echo $this->Form->control('item_id',array('type'=>'select','options'=>$items, 'name'=>'items[]','onchange'=>'change(this)'));?></td>
    		<td><?php echo $this->Form->control('unit_id',array('type'=>'select','options'=>$units, 'name'=>'units[]')); ?></td>
    		<td><?php echo $this->Form->control('quantity', array('name'=>'qty[]','required'=>'true')); ?></td>
    		<td><?php echo $this->Form->control('rate',array('name'=>'rate[]','required'=>'true')); ?></td>
    		<td><?php echo $this->Form->control('warehouse_id',array('type'=>'select','options'=>$warehouses, 'name'=>'warehouses[]')); ?></td>
    		<td><?php echo $this->Form->control('amount',array('name'=>'amount[]')); ?></td>
    	</tr>
    		<input type="button" onclick="add_row()" value="Add row" > 
    </table>
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
	
    var table =document.getElementById("purchase_ordersTable");
    var no_of_rows=$('#purchase_ordersTable tr').length;
    
    var row = table.insertRow().innerHTML = '<tr>\
    <td><select name="items[]" onchange="change(this)" id=item-id'+(no_of_rows)+'>'+item_options+'</select></td>\
    <td><select name="units[]" id=unit-id'+(no_of_rows)+'>'+unit_options+'</select></td>\
    <td><input type="text" name="qty[]" id=quantity-id'+(no_of_rows)+'onchange="cal_amt(this)"></td>\
    <td><input type="text" name="rate[]" id=rate-id'+(no_of_rows)+' onchange="cal_amt(this)"></td>\
    <td><?php echo $this->Form->control('',array('type'=>'select','options'=>$warehouses, 'name'=>'warehouses[]')); ?></td>\
    <td><input type="text" name="amount[]" id=amount-id'+(no_of_rows)+' onchange="cal_amt(this)"></td>\
    </tr>';
    
    var item_select_box = document.getElementById('item-id'+no_of_rows);
    change(item_select_box);
    }
    
     function change(element) 
	{
	var item_select_box=document.getElementById(element.id);
	
	//this will give the selected dropdown value,tht is item id
	
	var selected_value=item_select_box.options[item_select_box.selectedIndex].value;
	console.log(selected_value);
	current_row=element.id[element.id.length -1];
	
	//console.log(current_row);
	
	if(current_row =="d"){
			var unit=$('#unit-id');
	 		unit.empty();
			}
			else{
			var unit_select_box=$('#unit-id'+current_row);
			unit_select_box.empty();
		  }
	
	$.ajax({
			type: 'get',
			url: '/purchase-orders/getunits',
		    data: { 
		    itemid: selected_value
		    },
			beforeSend: function(xhr) {
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
			if (response.error) {
				alert(response.error);
				console.log(response.error);
			}
			if(response){
			if(current_row=="d"){
			for(var k in response){
			$("#unit-id").append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			      }
			  }
			else{
			for(var k in response)
				{
			   	$("#unit-id"+current_row).append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			  	}
				}
			}
		}
		
	});	
   //console.log(item-id);
	}
	function cal_amt(element)
	{
	var input_box=document.getElementById(element.id);
	console.log("element",input_box);
	console.log("rate_box");
	
	current_row=element.id[element.id.length -1]
	console.log("current_row",current_row);
	
	if(current_row == "Y" || current_row == "e"){
	var rate_box = "";
	if(current_row == "Y"){
		var rate_box = document.getElementById("rate");
		var amount = input_box.value*rate_box.value;
		console.log("rrrrrr",rate_box.value);
		}
		else{
		var qty_box =document.getElementById("quantity");
		var amount = input_box.value*qty_box.value;
		}
		console.log(amount);
		$('amount').text(amount);
		}
		else{
		console.log("in else");
		current_row = element.id[element.id.length-1]
		console.log("current_row",current_row);
		
		var qty_box = document.getElementById("quantity-id",+currrent-row); 
		var rate_box = document.getElementById("rate-id"+current_row);
		var amount = qty_box.avlue*rate_box.value;
		console.log(amount);
		}
	}	
	</script>