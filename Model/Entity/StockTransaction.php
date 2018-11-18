<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StockTransaction Entity
 *
 * @property int $id
 * @property string $item_id
 * @property int $warehouse_id
 * @property int $quantity
 * @property int $type
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property string $transaction_time
 *
 * @property \App\Model\Entity\Item $item
 * @property \App\Model\Entity\Warehouse $warehouse
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
        'warehouse_id' => true,
        'quantity' => true,
        'type' => true,
        'transaction_date' => true,
        'transaction_time' => true,
        'item' => true,
        'warehouse' => true
    ];
}
