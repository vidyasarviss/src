<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Rule\IsUnique;

use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
/**
 * Items Model
 *
 * @property \App\Model\Table\IngredientsTable|\Cake\ORM\Association\HasMany $Ingredients
 *
 * @method \App\Model\Entity\Item get($primaryKey, $options = [])
 * @method \App\Model\Entity\Item newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Item[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Item|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Item patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Item[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Item findOrCreate($search, callable $callback = null, $options = [])
 */
class ItemsTable extends Table
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

        $this->setTable('items');
        $this->setDisplayField('item_name');
        $this->setPrimaryKey('id');

        $this->hasMany('Ingredients', [
            'foreignKey' => 'item_id',
            'dependent'  => true,
            'cascadeCallbacks' => true
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
            ->scalar('item_name')
            ->maxLength('item_name', 250)
            ->requirePresence('item_name', 'create')
            ->notEmpty('item_name');

        $validator
            ->integer('purchase_unit')
            ->requirePresence('purchase_unit', 'create')
            ->notEmpty('purchase_unit');

        $validator
            ->integer('sell_unit')
            ->requirePresence('sell_unit', 'create')
            ->notEmpty('sell_unit');

        $validator
            ->integer('usage_unit')
            ->requirePresence('usage_unit', 'create')
            ->notEmpty('usage_unit');

        $validator
            ->integer('sell_unit_qty')
            ->requirePresence('sell_unit_qty', 'create')
            ->notEmpty('sell_unit_qty');

        $validator
            ->integer('usage_unit_qty')
            ->requirePresence('usage_unit_qty', 'create')
            ->notEmpty('usage_unit_qty');

        return $validator;
    }

public function beforeSave($event, $entity, $options)
{
    //debug($entity);die();
            $items_table = TableRegistry::get('Items');
            if(is_null($entity->id)){
                $items=$items_table->find('all')->where(['item_name'=>$entity->item_name])->count();
            }else{
            $items=$items_table->find('all')->where(['item_name'=>$entity->item_name,'id !=' =>$entity->id])->count();
            }
            if($items > 0)
            {
            return false;
            }
} 

}
