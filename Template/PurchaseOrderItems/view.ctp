<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrderItem $purchaseOrderItem
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Purchase Order Item'), ['action' => 'edit', $purchaseOrderItem->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Purchase Order Item'), ['action' => 'delete', $purchaseOrderItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrderItem->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Units'), ['controller' => 'Units', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Unit'), ['controller' => 'Units', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order'), ['controller' => 'PurchaseOrder', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['controller' => 'PurchaseOrder', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Warehouses'), ['controller' => 'Warehouses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Warehouse'), ['controller' => 'Warehouses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrderItems view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrderItem->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $purchaseOrderItem->has('item') ? $this->Html->link($purchaseOrderItem->item->item_name, ['controller' => 'Items', 'action' => 'view', $purchaseOrderItem->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Unit') ?></th>
            <td><?= $purchaseOrderItem->has('unit') ? $this->Html->link($purchaseOrderItem->unit->name, ['controller' => 'Units', 'action' => 'view', $purchaseOrderItem->unit->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Order') ?></th>
            <td><?= $purchaseOrderItem->has('purchase_order') ? $this->Html->link($purchaseOrderItem->purchase_order->name, ['controller' => 'PurchaseOrder', 'action' => 'view', $purchaseOrderItem->purchase_order->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Warehouse') ?></th>
            <td><?= $purchaseOrderItem->has('warehouse') ? $this->Html->link($purchaseOrderItem->warehouse->name, ['controller' => 'Warehouses', 'action' => 'view', $purchaseOrderItem->warehouse->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrderItem->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($purchaseOrderItem->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate') ?></th>
            <td><?= $this->Number->format($purchaseOrderItem->rate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Amount') ?></th>
            <td><?= $this->Number->format($purchaseOrderItem->amount) ?></td>
        </tr>
    </table>
</div>
