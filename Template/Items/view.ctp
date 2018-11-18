<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Item'), ['action' => 'edit', $item->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Item'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Items'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Item'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ingredients'), ['controller' => 'Ingredients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ingredient'), ['controller' => 'Ingredients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="items view large-9 medium-8 columns content">
    <h3><?= h($item->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Item Name') ?></th>
            <td><?= h($item->item_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($item->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Purchase Unit') ?></th>
            <td><?= $this->Number->format($item->purchase_unit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Sell Unit') ?></th>
            <td><?= $this->Number->format($item->sell_unit) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Usage Unit') ?></th>
            <td><?= $this->Number->format($item->usage_unit) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ingredients') ?></h4>
        <?php if (!empty($item->ingredients)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
               
                <th scope="col"><?= __('Unit Id') ?></th>
           </tr>
            <?php foreach ($item->ingredients as $ingredients): ?>
            <tr>
                <td><?= h($ingredients->id) ?></td>
                <td><?= h($ingredients->item_name) ?></td>
                <td><?= h($ingredients->quantity) ?></td>
                
                <td><?= h($ingredients->unit_name) ?></td>
               
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
