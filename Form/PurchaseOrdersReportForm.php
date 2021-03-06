<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class purchaseOrdersReportForm extends Form
{
    
    protected function _buildSchema(Schema $schema)
    {
        return $schema->addField('id', 'integer')
        ->addField('item', ['type' => 'string'])
        ->addField('unit', ['type' => 'string'])
        ->addField('Quantity', ['type' => 'integer'])
        ->addField('Rate', ['type' => 'integer'])
        ->addField('Warehouse', ['type' => 'string'])
        ->addField('Amount', ['type' => 'integer']);
        
    }
   
    protected function _execute(array $data)
    {
        
        return true;
    }
    

}
