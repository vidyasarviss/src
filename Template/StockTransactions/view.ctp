<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransaction $stockTransaction
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Stock Transaction'), ['action' => 'edit', $stockTransaction->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Stock Transaction'), ['action' => 'delete', $stockTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransaction->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Stock Transactions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stock Transaction'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Warehouses'), ['controller' => 'Warehouses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Warehouse'), ['controller' => 'Warehouses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="stockTransactions view large-9 medium-8 columns content">
    <h3><?= h($stockTransaction->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item') ?></th>
            <td><?= $stockTransaction->has('item') ? $this->Html->link($stockTransaction->item->item_name, ['controller' => 'Items', 'action' => 'view', $stockTransaction->item->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Warehouse') ?></th>
            <td><?= $stockTransaction->has('warehouse') ? $this->Html->link($stockTransaction->warehouse->name, ['controller' => 'Warehouses', 'action' => 'view', $stockTransaction->warehouse->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Time') ?></th>
            <td><?= h($stockTransaction->transaction_time) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($stockTransaction->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Quantity') ?></th>
            <td><?= $this->Number->format($stockTransaction->quantity) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= $this->Number->format($stockTransaction->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Transaction Date') ?></th>
            <td><?= h($stockTransaction->transaction_date) ?></td>
        </tr>
    </table>
</div>
