<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property string $item_name
 * @property int $purchase_unit
 * @property int $sell_unit
 * @property int $usage_unit
 * @property int $sell_unit_qty
 * @property int $usage_unit_qty
 *
 * @property \App\Model\Entity\Ingredient[] $ingredients
 */
class Item extends Entity
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
        'item_name' => true,
        'purchase_unit' => true,
        'sell_unit' => true,
        'usage_unit' => true,
        'sell_unit_qty' => true,
        'usage_unit_qty' => true,
        'ingredients' => true
    ];
}
