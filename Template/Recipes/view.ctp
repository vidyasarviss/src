<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Recipe $recipe
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Recipe'), ['action' => 'edit', $recipe->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Recipe'), ['action' => 'delete', $recipe->id], ['confirm' => __('Are you sure you want to delete # {0}?', $recipe->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Recipes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Recipe'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ingredients'), ['controller' => 'Ingredients', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ingredient'), ['controller' => 'Ingredients', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="recipes view large-9 medium-8 columns content">
    <h3><?= h($recipe->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Recipes Name') ?></th>
            <td><?= h($recipe->recipes_name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Category') ?></th>
            <td><?= h($recipe->category) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($recipe->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Preparation Method') ?></h4>
        <?= $this->Text->autoParagraph(h($recipe->preparation_method)); ?>
    </div>
    <div class="related">
        <h4><?= __('Related Ingredients') ?></h4>
        <?php if (!empty($recipe->ingredients)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Item Id') ?></th>
                <th scope="col"><?= __('Quantity') ?></th>
                <th scope="col"><?= __('Unit Id') ?></th>
            </tr>
            <?php foreach ($recipe->ingredients as $ingredient): ?>
            <tr>
                <td><?= h($ingredient->id) ?></td>
                <td><?= h($ingredient->item_name) ?></td>
                <td><?= h($ingredient->quantity) ?></td>
                <td><?= h($ingredient->unit_name) ?></td>

            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
