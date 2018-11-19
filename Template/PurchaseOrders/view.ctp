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
        <li><?= $this->Html->link(__('List Purchase Orders'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Purchase Order Items'), ['controller' => 'PurchaseOrderItems', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Purchase Order Item'), ['controller' => 'PurchaseOrderItems', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="purchaseOrders view large-9 medium-8 columns content">
    <h3><?= h($purchaseOrder->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Supplier') ?></th>
            <td><?= $purchaseOrder->has('supplier') ? $this->Html->link($purchaseOrder->supplier->name, ['controller' => 'Suppliers', 'action' => 'view', $purchaseOrder->supplier->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($purchaseOrder->id) ?></td>
        </tr>
       
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($purchaseOrder->transaction_date) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Required Date') ?></th>
            <td><?= h($purchaseOrder->required_date) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Purchase Order Items') ?></h4>
        <?php if (!empty($purchaseOrder->purchase_order_items)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Rate') ?></th>
                <th scope="col"><?= __('Warehouse Id') ?></th>
                <th scope="col"><?= __('Amount') ?></th>
            </tr>
            <?php foreach ($purchaseOrder->purchase_order_items as $purchaseOrderItems): ?>
            <tr>
                <td><?= h($purchaseOrderItems->id) ?></td>
                <td><?= h($purchaseOrderItems->item_name) ?></td>
                <td><?= h($purchaseOrderItems->unit_name) ?></td>
                <td><?= h($purchaseOrderItems->quantity) ?></td>
                <td><?= h($purchaseOrderItems->rate) ?></td>
                <td><?= h($purchaseOrderItems->warehouse_name) ?></td>
                <td><?= h($purchaseOrderItems->amount) ?></td>
                 
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
