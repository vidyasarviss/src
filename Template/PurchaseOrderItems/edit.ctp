<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrderItem $purchaseOrderItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseOrderItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderItem->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Purchase Order Items'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Order'), ['controller' => 'PurchaseOrder', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['controller' => 'PurchaseOrder', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Warehouses'), ['controller' => 'Warehouses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Warehouse'), ['controller' => 'Warehouses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseOrderItems form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseOrderItem) ?>
    <fieldset>
        <legend><?= __('Edit Purchase Order Item') ?></legend>
        <?php
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('unit_id', ['options' => $units]);
            echo $this->Form->control('purchase_order_id', ['options' => $purchaseOrder]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('rate');
            echo $this->Form->control('warehouse_id', ['options' => $warehouses]);
            echo $this->Form->control('amount');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
