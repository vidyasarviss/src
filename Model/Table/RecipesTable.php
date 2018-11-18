<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\TableRegistry;

/**
 * Recipes Model
 *
 * @property \App\Model\Table\IngredientsTable|\Cake\ORM\Association\HasMany $Ingredients
 *
 * @method \App\Model\Entity\Recipe get($primaryKey, $options = [])
 * @method \App\Model\Entity\Recipe newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Recipe[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Recipe|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recipe|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Recipe patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Recipe[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Recipe findOrCreate($search, callable $callback = null, $options = [])
 */
class RecipesTable extends Table
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

        $this->setTable('recipes');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Ingredients', [
            'foreignKey' => 'recipe_id',
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
            ->scalar('recipes_name')
            ->maxLength('recipes_name', 100)
            ->requirePresence('recipes_name', 'create')
            ->notEmpty('recipes_name');

        $validator
            ->scalar('category')
            ->maxLength('category', 100)
            ->requirePresence('category', 'create')
            ->notEmpty('category');

        $validator
            ->scalar('preparation_method')
            ->requirePresence('preparation_method', 'create')
            ->notEmpty('preparation_method');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        return $validator;
    }

public function beforeSave($event, $entity, $options)
{
    //debug($entity);die();
            $recipes_table = TableRegistry::get('Recipes'); 
            if(is_null($entity->id)){
                $recipe=$recipes_table->find('list')->where(['recipes_name' =>$entity->recipes_name])->count();
            }else{
            $recipe=$recipes_table->find('list')->where(['recipes_name'=>$entity->recipes_name,'id !=' =>$entity->id])->count();
            }
            if($recipe > 0)
            {
            return false;
            }
            
} 
}