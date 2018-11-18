<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchaseOrder Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property \Cake\I18n\FrozenDate $transaction_date
 * @property \Cake\I18n\FrozenDate $required_date
 * @property int $type
 *
 * @property \App\Model\Entity\Supplier $supplier
 * @property \App\Model\Entity\PurchaseOrderItem[] $purchase_order_items
 */
class PurchaseOrder extends Entity
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
        'supplier_id' => true,
        'transaction_date' => true,
        'required_date' => true,
        'type' => true,
        'supplier' => true,
        'purchase_order_items' => true
    ];
}
