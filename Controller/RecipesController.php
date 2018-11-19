<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use PhpParser\Node\Stmt\Foreach_;

/**
 * Recipes Controller
 *
 * @property \App\Model\Table\RecipesTable $Recipes
 *
 * @method \App\Model\Entity\Recipe[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RecipesController extends AppController
{


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        
        $recipes = $this->paginate($this->Recipes);
        $this->paginate['order']=['id'=>'DESC'];
        $this->set(compact('recipes'));
    }

    /**
     * View method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $recipe = $this->Recipes->get($id, [
            'contain' => ['Ingredients']
        ]);
                
        foreach($recipe->ingredients as $ingredient)
        {        
        	$items = TableRegistry::get('Items');      
	    	$ingredient->recipe_id=$recipe->id;
        	$ingredient->item_name = $items->get($ingredient->item_id)->item_name;
        	
             $units= TableRegistry::get('Units');
        	 $ingredient->recipe_id=$recipe->id;
			$ingredient->unit_name=$units->get($ingredient->unit_id)->name;        
        }
        
        

		//debug($recipe);die();
        $this->set('recipe', $recipe);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $data = $this->request->getData();
    	
        $recipe = $this->Recipes->newEntity();
        if ($this->request->is('post')) {
            $recipe = $this->Recipes->patchEntity($recipe, $data);
            if ($this->Recipes->save($recipe)) {
                $ing=TableRegistry::get('Ingredients'); 
                $i = 0;                             
                foreach($data['items'] as $item)
                {
	                $ingredient=$ing->newEntity();
	                $ingredient->recipe_id=$recipe->id;
                    $ingredient->item_id= $item;
	                $ingredient->quantity= $data['qty'][$i];
	                $ingredient->unit_id= $data['units'][$i];	 
	                $ing->save($ingredient);   
	                $i++;
	                        	                        	
	         	}	              	                  
			            
                $this->Flash->success(__('The recipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            
             //debug($recipe->errors());die();
            $units = TableRegistry::get('Units');
            $this->set('units',$units->find('list'));
            
            $recipes = TableRegistry::get('Recipes');
            $this->set('recipes',$recipes->find('list'));
            
            $items = TableRegistry::get('Items');
            $this->set('items',$items->find('list'));
            
            $category= TableRegistry::get('Categories');
            $this->set('category',$category->find('list'));
            
            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
        }else if($this->request->is('get')){
            $units = TableRegistry::get('Units');
            $this->set('units',$units->find('list'));
            
            $recipes = TableRegistry::get('Recipes');
            $this->set('recipes',$recipes->find('list'));
            
            $items = TableRegistry::get('Items');
            $this->set('items',$items->find('list'));
            
            $category= TableRegistry::get('Categories'); $data = $this->request->getData();
            $this->set('category',$category->find('list'));
            foreach ($items as $item)
            {
                $item->units=$units->find('list',['id IN '=>[$item->purchase_unit,$item->sell_unit,$item->usage_unit]]);
                
            }
        }
       
        $this->set(compact('recipe'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $data = $this->request->getData();
        $recipe = $this->Recipes->newEntity();
        $recipe = $this->Recipes->get($id, [
            'contain' => ['ingredients']
         ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
       
        //debug($data);die();
        //debug($this->request->getData();die();
            $recipe = $this->Recipes->patchEntity($recipe, $this->request->getData());
            
            if ($this->Recipes->save($recipe)) {
            	$ing=TableRegistry::get('Ingredients');
                $items=TableRegistry::get('Items'); 
                $i = 0;                             
                foreach($data['items'] as $item)
                {                	
                	$ingredient = $ing->find('all')->where(['item_id'=>$item,'recipe_id'=>$id])->first();
                	if($ingredient){
                	    $ingredient->item_id= $item;
                	    $ingredient->quantity= $data['qty'][$i];
                	    $ingredient->unit_id= $data['units'][$i];
                	    $ing->save($ingredient);
                	}else{
                    	$ingredient = $ing->newEntity();
                    	$ingredient->recipe_id=$recipe->id;
                    	$ingredient->item_id= $item;
                    	$ingredient->quantity= $data['qty'][$i];
                    	$ingredient->unit_id= $data['units'][$i];
                    	$ing->save($ingredient);
                	}
                	$i++;
               } 
              
                $this->Flash->success(__('The recipe has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $units = TableRegistry::get('Units');
            $this->set('units',$units->find('list'));
            
            $recipes = TableRegistry::get('Recipes');
            $this->set('recipes',$recipes->find('list'));
            
            $items = TableRegistry::get('Items');
            $this->set('items',$items->find('list'));
            
            $category= TableRegistry::get('Categories');
            $this->set('category',$category->find('list'));
            $this->Flash->error(__('The recipe could not be saved. Please, try again.'));
        }
        else if($this->request->is('get')){
            $units = TableRegistry::get('Units');
            $this->set('units',$units->find('list'));
            
            $recipes = TableRegistry::get('Recipes');
            $this->set('recipes',$recipes->find('list'));
            
            $items = TableRegistry::get('Items');
            $this->set('items',$items->find('list'));
            
            $category= TableRegistry::get('Categories');
            $this->set('category',$category->find('list'));
            
           $ingredients= TableRegistry::get('Ingredients');
            $this->set('ingredients',$ingredients->find('list'));
            foreach ($items as $item)
            {
                $item->units=$units->find('list',['id IN '=>[$item->purchase_unit,$item->sell_unit,$item->usage_unit]]);
                
            }
        }
        $this->set(compact('recipe'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Recipe id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $recipe = $this->Recipes->get($id);
        if ($this->Recipes->delete($recipe)) {
            $this->Flash->success(__('The recipe has been deleted.'));
        } else {
            $this->Flash->error(__('The recipe could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    
    
  public function getunits()
  {
    $this->RequestHandler->respondAs('json');
    $this->response->type('application/json');
    $this->autoRender = false ;      
      
    $itemid = $this->request->query();
    $items_table = TableRegistry::get('Items');
    $item = $items_table ->get($itemid['itemid']);
    $units_table = TableRegistry::get('Units');
    
   
    //$units_table= $this->units->find('list',array('fields' => array('units_table'),'conditions' => array('units'=>$value)));
    //foreach($units_length as $q)
    //{
        ///$units[]="<option>".$q."</option>";
    //}
    // print_r($units);
   
    $units=$units_table->find('list')->where(['id IN '=>[$item->purchase_unit,$item->sell_unit,$item->usage_unit]]);
    //debug($item->purchase_unit,$item->sell_unit,$item->usage_unit); die();
    //this gives template error, google "cakephp function response without template"
    
  //return json response
    
    $this->RequestHandler->renderAs($this, 'json');

    $resultJ=json_encode($units);
    $this->response->type('json');
    $this->response->body($resultJ);
    return $this->response;
    
  }
  public function getitems()
  {
  $this->RequestHandler->respondAs('json');
  $this->response->type('application/json');
  $this->autoRender = false ;
  $array=$this->request->data();
  //debug($array);die();
  $inid=$array;
  $this->set('inid',$inid);
  $ingredients_table = TableRegistry::get('Ingredients');
  foreach($inid['ingredientid'] as $id)
  {
      $ingstatus = $ingredients_table->get($id);
      $ingredients_table->delete($ingstatus);
  
  }
  
  $this->RequestHandler->renderAs($this,'json');
  
  $resultJ=json_encode($ingstatus);
  $this->response->type('json');
  $this->response->body($resultJ);
  return $this->response;
 }
}
