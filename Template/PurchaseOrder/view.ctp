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
        <li><?= $this->Html->link(__('List Purchase Order'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrder view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrder->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= h($purchaseOrder->supplier) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrder->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Required Date') ?></th>
            <td><?= h($purchaseOrder->required_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Items') ?></h4>
        <?php if (!empty($purchaseOrder->items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Name') ?></th>
                <th scope="col"><?= __('Purchase Unit') ?></th>
                <th scope="col"><?= __('Sell Unit') ?></th>
                <th scope="col"><?= __('Usage Unit') ?></th>
                <th scope="col"><?= __('Sell Unit Qty') ?></th>
                <th scope="col"><?= __('Usage Unit Qty') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($purchaseOrder->items as $items): ?>
            <tr>
                <td><?= h($items->id) ?></td>
                <td><?= h($items->item_name) ?></td>
                <td><?= h($items->purchase_unit) ?></td>
                <td><?= h($items->sell_unit) ?></td>
                <td><?= h($items->usage_unit) ?></td>
                <td><?= h($items->sell_unit_qty) ?></td>
                <td><?= h($items->usage_unit_qty) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
 <script>
 	function do_onload()
 	{
 		var poCount = $('#viewTable tr').length;
 		console.log('cvcbhvbvbj',poCount);
 		for(var i=1; i<poCount; i++)
 		{
 		console.log("hhhhhhhhhhhhhh",$('#quantity'+i));
 		var qty = $('#quantity_id'+i).text();
 		var rate = $('#rate_id'+i).text();
 		var amount = pareseFloat(qty) * parseFloat(rate);
	 	$('#amount_id'+i).text(amount);
 		console.log(amount,qty,rate);
 		}
 	}
 	window.onload = do_load();
 </script>