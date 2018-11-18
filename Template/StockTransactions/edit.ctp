<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StockTransaction $stockTransaction
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $stockTransaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $stockTransaction->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Stock Transactions'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Items'), ['controller' => 'Items', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Item'), ['controller' => 'Items', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Warehouses'), ['controller' => 'Warehouses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Warehouse'), ['controller' => 'Warehouses', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="stockTransactions form large-9 medium-8 columns content">
    <?= $this->Form->create($stockTransaction) ?>
    <fieldset>
        <legend><?= __('Edit Stock Transaction') ?></legend>
        <?php
            echo $this->Form->control('item_id', ['options' => $items]);
            echo $this->Form->control('warehouse_id', ['options' => $warehouses]);
            echo $this->Form->control('quantity');
            echo $this->Form->control('type');
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('transaction_time');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
