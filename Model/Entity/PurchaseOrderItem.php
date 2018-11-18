<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseOrderItem Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $unit_id
 * @property int $purchase_order_id
 * @property int $quantity
 * @property int $rate
 * @property int $warehouse_id
 * @property int $amount
 *
 * @property \App\Model\Entity\Item $item
 */
class PurchaseOrderItem extends Entity
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
        'unit_id' => true,
        'purchase_order_id' => true,
        'quantity' => true,
        'rate' => true,
        'warehouse_id' => true,
        'amount' => true,
        'item' => true
    ];
}
