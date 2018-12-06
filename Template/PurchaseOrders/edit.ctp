<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrder $purchaseOrder
 */
?>

            <div class="message success success-message" onclick="this.classList.add('hidden')">The purchase order has been saved.</div>
            
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
            //$this->Form->templates(['dateWidget'=>'{{day}}{{month}}{{year}}']);
            //echo $this->Form->control('transaction_date');
            //echo $this->Form->control('required_date');
            
        ?>
        transaction_date <input type="date" id="t_date" name="transaction_date" value="<?php echo date ("Y-m-d",strtotime($purchaseOrder->transaction_date))?>">
        required_date    <input type="date" id="r_date" name="required_date" value="<?php echo date("Y-m-d", strtotime($purchaseOrder->required_date))?>" onchange="dateComp()">
        
        
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
            $amount= 'amount'.$index;
    ?>
    <tr>
    <td><?php echo $this->Form->control('checkbox',array('type'=>'checkbox','name'=>'chk[]','id'=>$purchaseOrderItems->id));?></td>
    <td><?php echo $this->Form->control('item_id',array('type'=>'select','options'=>$items,'default'=>$purchaseOrderItems->item_id,'name'=>'items[]','id'=>$itemid,'onchange'=>'change(this)','disabled'=>'true'));?></td>
    <td><?php echo $this->Form->control('item_id',array('type'=>'hidden','options'=>$items,'default'=>$purchaseOrderItems->item_id,'name'=>'items[]','id'=>$itemid,'onchange'=>'change(this)'));?></td>
    <td><?php echo $this->Form->control('unit_id',array('type'=>'select','options'=>$units,'default'=>$purchaseOrderItems->unit_id,'name'=>'units[]','id'=>$unitid)); ?></td>
    <td><?php echo $this->Form->control('quantity', array('type'=>'number','name'=>'qty[]','required'=>'true','onchange'=>'calculate_amount(this)','id'=>$quantity,'default'=>$purchaseOrderItems->quantity)); ?></td>
    <td><?php echo $this->Form->control('rate',array('type'=>'number','name'=>'rate[]','required'=>'true','onchange'=>'calculate_amount(this)','id'=>$rate,'default'=>$purchaseOrderItems->rate)); ?></td>
    <td><span id='<?php echo $amount ?>'></span></td>
    <td><?php echo $this->Form->control('warehouse_id',array('type'=>'select','options'=>$warehouses,'default'=>$purchaseOrderItems->warehouse_id,'name'=>'warehouses[]','id'=>$warehouse)); ?></td>
    </tr>
    
    <?php
    $index++;
    }
    ?>
    <input type="button" onclick="add_row();hide_submit();"  value="Add Row" >
    <input type="button" id="delrtbutton" value="Delete row" onclick="delcheck()"> 
    
    
    </table>
    <button type="submit" id="smtbutton" value="submit"> Submit </button>
    <?= $this->Form->end() ?>
   
</div>
<script src="/js/jquery-3.3.1.min.js"> </script>
 <script>

 function do_onload()
 {
 console.log('vvvvvvvv1111');
 var item_select_box=document.getElementById('item_id');
 var poCount = $('#purchase_ordersTable tr').length;
 console.log('fgfgj',poCount);
  for(var i=1; i<=poCount;i++){
    console.log("www"); 
  	console.log("bbnbnbn", $('#item_id'+i));
  	var item_id = $('#item_id'+i).attr('id');
  	//console.log("item_id_select", item_id);
  	change(item_id);
  	}
  	}
  	window.onload = do_onload();
  	console.log("jghfj");
  	
  	
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
	
	var warehouses = <?php echo json_encode($warehouses) ?>;
	var warehouse_options = "";
	for(var k in warehouses)
	{
	warehouse_options+= "<option value=' "+ k +" '>" +warehouses[k]+ "</option>";
	}
	
	var table = document.getElementById("purchase_ordersTable");
	var poCount = $('#purchase_ordersTable tr').length;
    var no_of_rows=$('#purchase_ordersTable tr').length;
    var row = table.insertRow().innerHTML = '<tr>\
    <td><input type="checkbox" name="chk[]" id=chk'+(poCount+1)+'></td>\
    <td><select name="items[]" onchange="change(this.id)" id=item_id'+(no_of_rows+1)+'>'+item_options+'</select></td>\
    <td></td>\
    <td><select name="units[]" id=unit_id'+(no_of_rows+1)+'>'+unit_options+'</select></td>\
    <td><input type="number" name="qty[]" id=quantity_id'+(no_of_rows+1)+' onchange="calculate_amount(this)"></td>\
    <td><input type="number" name="rate[]" id=rate_id'+(no_of_rows+1)+' onchange="calculate_amount(this)"></td>\
    <td><span id=amount'+(no_of_rows+1)+'></span></td>\
    <td><select name="warehouses[]" id=warehouse_id'+(no_of_rows+1)+'>'+warehouse_options+'</select></td>\
    </tr>';
    var item_select_box = document.getElementById('item_id'+(no_of_rows+1));
    change(item_select_box.id);
    console.log("hjhdfj");
    }
    
function change(id) 
	{
	
	console.log("bbb",id);
	var item_select_box=document.getElementById(id);
	
	//this will give the selected dropdown value,tht is item id
	console.log("jjj");
	var selected_value=item_select_box.options[item_select_box.selectedIndex].value;
	          //console.log("lll");
	console.log("element id",id);
           //console.log(selected_value);
     var element_id= id.replace(/[^0-9]/g, '');
     
     console.log("opooooo ",element_id);
     
	if(element_id >=1){
			var unit=$('#unit_id'+element_id);
			console.log("unit111111 ",unit);
	 		unit.empty();
			}
			
		$.ajax({
			type: 'get',
			url: '/purchase-orders/getunits',
			async: false,
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
				console.log(response.error);
			}
			if(response){
			if(element_id >= 1){
			console.log("jhjjhhjjj");
			for(var k in response)
			{
			$("#unit_id"+element_id).append("<option value=' "+ k +" '>" +response[k]+ "</option>");
			      }
			      console.log("1111111d","#unit-id"+element_id);
			  }
			
				
			}
		}
		
	});	
  
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
					$('.success-message').hide();
                	$('.error-message').show();
                	$('.error-message').html("The purchase order could not be deleted. Please, try again.");
                	$('.error-message').fadeIn();
					alert(response.error);
					console.log(response.error);
					}
					
				if(response){
					checkbox_id.forEach(function(entry){
					console.log(entry);
					var chkid = $('#'+entry);
			    	chkid.closest('tr').remove();
			    	
					$('.success-message').show();
                	$('.error-message').hide();
                	$('.success-message').html("The purchase order has been deleted");
                	$('.success-message').fadeIn();			    	
				});
				hide_submit();
				}
				}
	});
	//console.log(chkid);
	}
	}
	
	function calculate_amount(element)
   {     
	
	var element_id=element.id.replace(/[^0-9]/g, '');
	//console.log("eleid",element_id);	
	
	var rate_box = document.getElementById("rate_id"+element_id);
    //console.log("vyutgughu75655555555785",rate_box);
	
    var qty_box=document.getElementById("quantity_id"+element_id);
    //console.log("vyutgughu75655555555785",qty_box);
    
			
	
	var element_id= element.id.replace(/[^0-9]/g, '');
	//console.log("opooooo ",element_id);
   	
	   if(element_id>=1)
			{
			
			var amount = qty_box.value * rate_box.value;
		    $('#amount'+element_id).html(amount); 
           }
  }

	
	function hide_submit()
	{
		console.log("vvvv");
		var no_of_rows = $('#purchase_ordersTable tr').length;
		
		if(no_of_rows == 0)
		{
	 		var sub=$('#smtbutton').hide();
	 	}else{
	 		var sub=$('#smtbutton').show();
	  		 }
	}
  	window.onload = hide_submit();
  	
  function dateComp()
  {
   
   var date1 = $('#t_date').val();
   var date2 = $('#r_date').val();
   
  	if(date1 >= date2)
  		{
  		alert('Transaction date cannot be greater then required date')
    	}else{
    	alert('Entered date is valid')
    	}

  }
 // <div class="message success error-message" onclick="this.classList.add('hidden')">The purchase order has been saved.</div>

	</script>