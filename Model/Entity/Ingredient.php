<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ingredient Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $quantity
 * @property int $recipe_id
 * @property int $unit_id
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Recipe $recipe
 * @property \App\Model\Entity\Unit $unit
 */
class Ingredient extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'item_id' => true,
        'quantity' => true,
        'recipe_id' => true,
        'unit_id' => true,
        'item' => true,
        'recipe' => true,
        'unit' => true
    ];
}
