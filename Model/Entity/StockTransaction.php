<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockTransaction Entity
 *
 * @property int $id
 * @property int $item_id
 * @property int $unit_id
 * @property int $warehouse_id
 * @property int $type
 * @property int $quantity
 * @property int $rate
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property int $referenceid
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Unit $unit
 * @property \App\Model\Entity\Warehouse $warehouse
 * @property \App\Model\Entity\Reference $reference
 */
class StockTransaction extends Entity
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
        'warehouse_id' => true,
        'type' => true,
        'quantity' => true,
        'rate' => true,
        'transaction_date' => true,
        'referenceid' => true,
        'item' => true,
        'unit' => true,
        'warehouse' => true,
        'reference' => true
    ];
}
