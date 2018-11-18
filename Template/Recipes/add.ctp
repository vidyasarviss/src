<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recipe $recipe
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Recipes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="recipes form large-9 medium-8 columns content">
    <?= $this->Form->create($recipe) ?>
    <fieldset>
        <legend><?= __('Add Recipe') ?></legend>
        <?php
            echo $this->Form->control('recipes_name');
            echo $this->Form->control('category',array('type'=>'select','options'=>$category)); 
            echo $this->Form->control('preparation_method');
        ?>
        
        
       
    </fieldset>
    
    <table id="recipeTable">
    <tr>
    <td><?php echo $this->Form->control('item_id',array('type'=>'select','options'=>$items, 'name'=>'items[]','onchange'=>'change(this)')); ?></td>
    <td><?php echo $this->Form->control('quantity', array('name'=>'qty[]','required'=>'true')); ?></td>
    <td><?php echo $this->Form->control('unit_id',array('type'=>'select','options'=>$units, 'name'=>'units[]')); ?></td>
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
	
    var table = document.getElementById("recipeTable");
    var no_of_rows=$('#recipeTable tr').length;
    
    var row = table.insertRow().innerHTML = '<tr>\
    <td><select name="items[]" onchange="change(this)" id=item-id'+(no_of_rows)+'>'+item_options+'</select></td>\
    <td><?php echo $this->Form->control(' ', array('name'=>'qty[]')); ?></td>\
    <td><select name="units[]" id=unit-id'+(no_of_rows)+'>'+unit_options+'</select></td>\
    </tr>';
    }
  function change(element) 
	{
	
	//console.log("bbb");
	var item_select_box=document.getElementById(element.id);
	
	//this will give the selected dropdown value,tht is item id
	
	var selected_value=item_select_box.options[item_select_box.selectedIndex].value;
	console.log(selected_value);
	current_row=element.id[element.id.length -1];
	
	console.log(current_row);
	
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
			url: '/recipes/getunits',
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
	</script>