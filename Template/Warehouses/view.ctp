<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Warehouse $warehouse
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Warehouse'), ['action' => 'edit', $warehouse->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Warehouse'), ['action' => 'delete', $warehouse->id], ['confirm' => __('Are you sure you want to delete # {0}?', $warehouse->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Warehouses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Warehouse'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Stock Transactions'), ['controller' => 'StockTransactions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Stock Transaction'), ['controller' => 'StockTransactions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="warehouses view large-9 medium-8 columns content">
    <h3><?= h($warehouse->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($warehouse->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($warehouse->id) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Stock Transactions') ?></h4>
        <?php if (!empty($warehouse->stock_transactions)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Warehouse Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Type') ?></th>
                <th scope="col"><?= __('Transaction Date') ?></th>
                <th scope="col"><?= __('Transaction Time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($warehouse->stock_transactions as $stockTransactions): ?>
            <tr>
                <td><?= h($stockTransactions->id) ?></td>
                <td><?= h($stockTransactions->item_id) ?></td>
                <td><?= h($stockTransactions->warehouse_id) ?></td>
                <td><?= h($stockTransactions->quantity) ?></td>
                <td><?= h($stockTransactions->type) ?></td>
                <td><?= h($stockTransactions->transaction_date) ?></td>
                <td><?= h($stockTransactions->transaction_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'StockTransactions', 'action' => 'view', $stockTransactions->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'StockTransactions', 'action' => 'edit', $stockTransactions->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'StockTransactions', 'action' => 'delete', $stockTransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransactions->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
