

<div class="purchaseOrders index large-8 medium-9 columns content">
    <h3><?= __('Purchase Orders Report') ?></h3>
<table>
      <tr>
    		<td>From date <input type=date id="t_date" name="transaction_date" value= "<?php echo $def_date;?>" ></td>
    		<td>To date <input type=date id="r_date"  name="required_date" value= "<?php echo $def_date;?>" > </td>
    		<td><?php echo $this->Form->control('Warehouse', array('type'=>'select','name'=>'warehouses[]')); ?></td>
    		<td><?php echo $this->Form->control('Item',array('type'=>'select','name'=>'items[]')); ?></th>
    		<td><button type="submit" value="submit" onclick="check_submit()"> Submit </button></td>
    	</tr>
</table>
<table>
      <tr>
           <th>id</th>
           <th>Transaction date</th>
           <th>Required date</th>
           <th>Warehouse</th>
           <th>Item</th>
           <th>Quantity</th>
           <th>Rate</th>
      </tr>
        <tbody>
            <?php foreach ($pos as $poitem): ?>
            <tr>
                <td><?= h($poitem->po['id']) ?></td>
                <td><?= h($poitem->po['transaction_date']) ?></td>
                <td><?= h($poitem->po['required_date'] )?></td>
                <td><?= h($poitem->warehouse->name)?></td>
                <td><?= h($poitem->item->item_name) ?></td>
                <td><?= h($poitem->quantity) ?></td>
                <td><?= h($poitem->rate) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>      
</table>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
<script>

function check_submit()
{

var transaction_date=$('#t_date').val();
console.log("fdjk",transaction_date);

var required_date=$('#r_date').val();
console.log("hfjkj",required_date);
 
 var warehouse=document.getElementById("warehouse");
 var selected_value = warehouse.options[warehouse.selectedIndex].value;
 console.log("ghg");
 
 var item=document.getElementById("item");
 var item_selected_value = item.options[item.selectedIndex].value;
 console.log("ttt");

window.location.assign("http://localhost:8765/purchase-ordersReport?warehouse_id="+selected_value+"&item_id="+item_selected_value+"&transaction_date="+transaction_date+"&required_date="+required_date);
}


</script>


        
    
