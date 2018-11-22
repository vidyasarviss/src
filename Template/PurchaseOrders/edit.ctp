<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrder $purchaseOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseOrder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrder->id)]
            )
        ?></li>
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
        <legend><?= __('Edit Purchase Order') ?></legend>
        <?php
            echo $this->Form->control('supplier_id', ['options' => $suppliers, 'empty' => true]);
            $this->Form->templates(['dateWidget'=>'{{day}}{{month}}{{year}}']);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('required_date');
            
        ?>
    </fieldset>
    <table id="purchase_ordersTable">
    <?php
    $index=1;
    foreach ($purchaseOrder->purchase_order_items as $purchaseOrderItems)
    {		
    		$itemid = 'item_id'.$index;
    		$unitid = 'unit_id'.$index;
     		$quantity = 'quantity_id'.$index;
     		$rate = 'rate_id'.$index;
            $warehouse = 'warehouse_id'.$index;
    ?>
    <tr>
    <td><?php echo $this->Form->control('checkbox',array('type'=>'checkbox','name'=>'chk[]','id'=>$purchaseOrderItems->id));?></td>
    <td><?php echo $this->Form->control('item_id',array('type'=>'select','options'=>$items,'default'=>$purchaseOrderItems->item_id,'name'=>'items[]','id'=>$itemid,'onchange'=>'change(this)'));?></td>
    <td><?php echo $this->Form->control('unit_id',array('type'=>'select','options'=>$units,'default'=>$purchaseOrderItems->unit_id,'name'=>'units[]','id'=>$unitid)); ?></td>
    <td><?php echo $this->Form->control('quantity', array('type'=>'number','name'=>'qty[]','required'=>'true','onchange'=>'calculate_amount(this)','default'=>$purchaseOrderItems->quantity)); ?></td>
    <td><?php echo $this->Form->control('rate',array('type'=>'number','name'=>'rate[]','required'=>'true','onchange'=>'calculate_amount(this)','default'=>$purchaseOrderItems->rate)); ?></td>
    <td><?php echo $this->Form->control('warehouse_id',array('type'=>'select','options'=>$warehouses, 'default'=>$purchaseOrderItems->warehouse_id,'name'=>'warehouses[]')); ?></td>
    <td><span id='amount'></span></td>
    </tr>
    
    <?php
    $index++;
    }
    ?>
    <input type="button" onclick="add_row()" value="Add Row" >
    <input type="button" id="delrtbutton" value="Delete row" onclick="check()"> 
    
    
    </table>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
   
</div>
<script src="/js/jquery-3.3.1.min.js"> </script>
 <script>
 
 function do_onload(){
 console.log('vvvvvvvv1111');
 var smCount = $('#purchase_orderTable tr').length;
 console.log('fgfgj',smCount);
  for(var i=1; i<smCount;i++){
  	console.log("bbnbnbn", $('#item_id'+1));
  	console.log("item_id_select", item_id_select);
  	
  	change(item_id_select);
  	}
  	}
  	window.onload = do_onload();
    
 	function add_row()
 	{
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
	var rowCount = $('#purchase_ordersTable tr').length; 
    var no_of_rows=$('#purchase_ordersTable tr').length;
    var row = table.insertRow().innerHTML = '<tr>\
    <td><input type="checkbox" name="chk[]" id=chk'+(rowCount+1)+'></td>\
    <td><select name="items[]" onchange="change(this)" id=item_id'+(no_of_rows)+'>'+item_options+'</select></td>\
    <td><select name="units[]" id=unit_id'+(no_of_rows)+'>'+unit_options+'</select></td>\
    <td><input type="number" name="qty[]" id=quantity-id'+(no_of_rows)+' onchange="calculate_amount(this)"></td>\
    <td><input type="number" name="rate[]" id=rate-id'+(no_of_rows)+' onchange="calculate_amount(this)"></td>\
    <td><?php echo $this->Form->control(' ',array('type'=>'select','options'=>$warehouses, 'name'=>'warehouses[]')); ?></td>\
    <td><span id=amount'+(no_of_rows)+'></span></td>\
    </tr>';
    
    var item_select_box = document.getElementById('item_id'+no_of_rows);
    change(item_select_box);
    }
    
function change(element) 
	{
	
	console.log("bbb");
	var item_select_box=document.getElementById(element.id);
	
	//this will give the selected dropdown value,tht is item id
	
	var selected_value=item_select_box.options[item_select_box.selectedIndex].value;
    console.log(selected_value);
	current_row=element.id[element.id.length -1]
	
	console.log(current_row);
	
	if(current_row =="d"){
			var unit=$('#unit_id');
	 		unit.empty();
			}
			else{
			var unit_select_box=$('#unit_id'+current_row);
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
			$("#unit_id").append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			      }
			  }
			else{
			for(var k in response)
				{
			   	$("#unit_id"+current_row).append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			  	}
				}
			}
		}
		
	});	
  
	}
	function check()
	{
		var puchase_order_item_dlt=$('#puchase_order_itemid');
		var check_box=document.getElementsByName("chk[]");
		var checkbox_id = new Array();
		$("input[name='chk[]']:checked").each(function(){
			console.log($(this).attr('id'));		
			if($(this).is(":checked")){
				var chkid = $('#'+$(this).attr('id'));
				var isnum = /^\d+$/.test($(this).attr('id'));				
				if(!isnum)
				{				
					chkid.closest("tr").remove();
				}
				else{
				   checkbox_id.push($(this).attr('id'));
				}
			}
	});
	
	if(checkbox_id.length > 0){
	console.log(checkbox_id);
	$.ajax({ 
			type: 'POST',
			async:true,
			cache:false,
			url: '/purchase-orders/getitems',
		  	data: { 
		    purchase_order_itemid:checkbox_id
		  	},
		  	dataType: 'json',
			beforeSend: function(xhr) {
			//xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('X-CSRF-Token',$('[name="_csrfToken"]').val());
			},
			success: function(response) {
				if (response.error) {
					alert(response.error);
					console.log(response.error);
					}
				if(response){
					checkbox_id.forEach(function(entry){
					console.log(entry);
					var chkid = $('#'+entry);
			    	chkid.closest('tr').remove();
				});
				}
				}
	});
	//console.log(chkid);
	}
	}
	function calculate_amount(element){     
	var input_box = document.getElementById(element.id);
	console.log("element ",input_box);
	
	//var rate_box = document.getElementById("rate"+1);
	//console.log("rate_box");
	//substring qty.id, get last number
		current_row = element.id[element.id.length -1]
		console.log("current_row ",current_row); 	
	if(current_row == "y" || current_row == "e"){
		var rate_box = "";
		if(current_row == "y"){
			var rate_box = document.getElementById("rate");
			var amount = input_box.value * rate_box.value;
			console.log("rrrrrrr ",rate_box.value);
		}else{
			var qty_box = document.getElementById("quantity");
			var amount = input_box.value * qty_box.value;
		}    
		console.log("hjhjhjh ", amount);
		$('#amount').html(amount); 
	}else{
		console.log("in else");
		current_row = element.id[element.id.length -1]
		console.log("current_row ",current_row); 

		var qty_box = document.getElementById("quantity-id"+current_row);
		var rate_box = document.getElementById("rate-id"+current_row);
		var amount = qty_box.value * rate_box.value;
		console.log(amount);
		$('#amount'+current_row).html(amount);
	}
	
}
	
	</script>