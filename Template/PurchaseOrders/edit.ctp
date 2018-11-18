<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseOrder $purchaseOrder
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchaseOrder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchaseOrder->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Purchase Orders'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Suppliers'), ['controller' => 'Suppliers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier'), ['controller' => 'Suppliers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Purchase Order Items'), ['controller' => 'PurchaseOrderItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Purchase Order Item'), ['controller' => 'PurchaseOrderItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="purchaseOrders form large-9 medium-8 columns content">
    <?= $this->Form->create($purchaseOrder) ?>
    <fieldset>
        <legend><?= __('Edit Purchase Order') ?></legend>
        <?php
            echo $this->Form->control('supplier_id', ['options' => $suppliers, 'empty' => true]);
            echo $this->Form->control('transaction_date');
            echo $this->Form->control('required_date');
            echo $this->Form->control('type');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
