<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseOrder Model
 *
 * @property \App\Model\Table\ItemsTable|\Cake\ORM\Association\BelongsToMany $Items
 *
 * @method \App\Model\Entity\PurchaseOrder get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseOrder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseOrder|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseOrder findOrCreate($search, callable $callback = null, $options = [])
 */
class PurchaseOrderTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('purchase_order');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Items', [
            'foreignKey' => 'purchase_order_id',
            'targetForeignKey' => 'item_id',
            'joinTable' => 'purchase_order_items'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('supplier')
            ->maxLength('supplier', 255)
            ->requirePresence('supplier', 'create')
            ->notEmpty('supplier');

        $validator
            ->date('required_date')
            ->allowEmpty('required_date');

        return $validator;
    }
}
