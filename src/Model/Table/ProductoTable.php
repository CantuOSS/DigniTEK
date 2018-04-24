<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProductoTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idproducto');
        $this->addBehavior('Timestamp');
    }  

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('nombre')
            ->notEmpty('nombre')

            ->requirePresence('descripcion')
            ->notEmpty('descripcion')              
            
            ->requirePresence('precio')
            ->notEmpty('precio');                     
            
        return $validator;
    }     
}
?>