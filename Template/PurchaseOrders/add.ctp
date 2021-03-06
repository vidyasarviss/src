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
            //$this->Form->templates(['dateWidget'=>'{{day}}{{month}}{{year}}']);
            //echo $this->Form->control('transaction_date');
            //echo $this->Form->control('required_date');
        ?>
        Transaction date <input type="date" id="t_date" name="transaction_date">
        Required date    <input type="date" id="r_date" name="required_date" onchange="dateComp()">
    </fieldset>
    
    <table id="purchase_ordersTable">
    	<tr>
    		<td><?php echo $this->Form->control('checkbox',array('type'=>'checkbox','name'=>'chk[]','id'=>'chk[]'));?></td>
    		<td><?php echo $this->Form->control('item_id',array('type'=>'select','options'=>$items, 'name'=>'items[]','onchange'=>'change(this)'));?></td>
    		<td><?php echo $this->Form->control('unit_id',array('type'=>'select','options'=>$units, 'name'=>'units[]')); ?></td>
    		<td><?php echo $this->Form->control('quantity', array('type'=>'number','name'=>'qty[]','required'=>'true','onchange'=>'calculate_amount(this)')); ?></td>
    		<td><?php echo $this->Form->control('rate',array('type'=>'number','name'=>'rate[]','required'=>'true','onchange'=>'calculate_amount(this)')); ?></td>
    		<td><span id=amount></span></td>
    		<td><?php echo $this->Form->control('warehouse_id',array('type'=>'select','options'=>$warehouses, 'name'=>'warehouses[]')); ?></td>
    	</tr>
    		<input type="button" onclick="add_row()" value="Add row" > 
    		<input type="button" id="delrtbutton" value="Delete row" onclick="delcheck()"> 
    </table>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<script src="/js/jquery-3.3.1.min.js"></script>
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
    var rowCount = $('#purchase_ordersTable tr').length;
    var row = table.insertRow().innerHTML = '<tr>\
    <td><input type="checkbox" name="chk[]" id=chk'+(rowCount+1)+'></td>\
    <td><select name="items[]" onchange="change(this)" id=item-id'+(no_of_rows)+'>'+item_options+'</select></td>\
    <td><select name="units[]" id=unit-id'+(no_of_rows)+'>'+unit_options+'</select></td>\
    <td><input type="number" name="qty[]" id=quantity-id'+(no_of_rows)+' onchange="calculate_amount(this)"></td>\
    <td><input type="number" name="rate[]" id=rate-id'+(no_of_rows)+' onchange="calculate_amount(this)"></td>\
    <td><span id=amount'+(no_of_rows)+'></span></td>\
    <td><?php echo $this->Form->control('',array('type'=>'select','options'=>$warehouses, 'name'=>'warehouses[]')); ?></td>\
    </tr>';
    
    var item_select_box = document.getElementById('item-id'+no_of_rows);
    change(item_select_box);
    }
    
  function change(element) 
	{
	var item_select_box=document.getElementById(element.id);
	
	//this will give the selected dropdown value,tht is item id
	
	var selected_value=item_select_box.options[item_select_box.selectedIndex].value;
	console.log("1111111111111",selected_value);
	
	console.log(element.id);
	
	var element_id=element.id.replace(/[^0-9]/g, '');
	console.log("ghgh",element_id);
	
	
	if(element_id ==""){
	console.log("jjjj");
			var unit=$('#unit-id');
	 		unit.empty();
			}
			if(element_id>=1){
			var unit_select_box=$('#unit-id'+element_id);
			unit_select_box.empty();
		  }
	
	$.ajax({
			type: 'get',
			url: '/purchase-orders/getunits',
		    data: { 
		    itemid: selected_value
		    },
		    dataType: 'json',
			beforeSend: function(xhr) {
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
			if (response.error) {
				alert(response.error);
				//console.log(response.error);
			}
			if(response){
			if(element_id==""){
			for(var k in response){
			$("#unit-id").append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			      }
			      console.log("1111111d","#unit-id");
			     }
			if(element_id>=1){
			for(var k in response)
				{
			   	$("#unit-id"+element_id).append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			  	}
				}
			}
		}
		
	});	
    //console.log(item-id);
	}
	function delcheck()
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
	
function calculate_amount(element)
{     
	var qty = document.getElementById("quantity");
	//console.log("vyutgughu75655555555785",qty);
	var rate= document.getElementById("rate");
	//console.log("jhjhjk",rate);
   	
	var element_id=element.id.replace(/[^0-9]/g, '');
	//console.log("eleid",element_id);
		
	if(element_id=="")
    {	
		var amount = qty.value * rate.value;
	    $('#amount').html(amount); 		
	}
			
	   if(element_id>=1)
			{
			var rate_box = document.getElementById("rate-id"+element_id);
			var qty_box=document.getElementById("quantity-id"+element_id);
			
			
			var amount = qty_box.value * rate_box.value;
		    $('#amount'+element_id).html(amount); 
           }
  }

function dateComp()
  {
   
   var date1 = $('#t_date').val();
   var date2 = $('#r_date').val();
   
  	if(date1 >= date2)
  		{
  		alert('transaction date cannot be greater then required date')
    	}else{
    	alert('valid date')
    	}

  }
  
	</script>