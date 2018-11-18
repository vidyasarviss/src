<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransaction[]|\Cake\Collection\CollectionInterface $stockTransactions
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Stock Transaction'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Warehouses'), ['controller' => 'Warehouses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Warehouse'), ['controller' => 'Warehouses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stockTransactions index large-9 medium-8 columns content">
    <h3><?= __('Stock Transactions') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('item_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('warehouse_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('quantity') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_date') ?></th>
                <th scope="col"><?= $this->Paginator->sort('transaction_time') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stockTransactions as $stockTransaction): ?>
            <tr>
                <td><?= $this->Number->format($stockTransaction->id) ?></td>
                <td><?= $stockTransaction->has('item') ? $this->Html->link($stockTransaction->item->item_name, ['controller' => 'Items', 'action' => 'view', $stockTransaction->item->id]) : '' ?></td>
                <td><?= $stockTransaction->has('warehouse') ? $this->Html->link($stockTransaction->warehouse->name, ['controller' => 'Warehouses', 'action' => 'view', $stockTransaction->warehouse->id]) : '' ?></td>
                <td><?= $this->Number->format($stockTransaction->quantity) ?></td>
                <td><?= $this->Number->format($stockTransaction->type) ?></td>
                <td><?= h($stockTransaction->transaction_date) ?></td>
                <td><?= h($stockTransaction->transaction_time) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $stockTransaction->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $stockTransaction->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $stockTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransaction->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
