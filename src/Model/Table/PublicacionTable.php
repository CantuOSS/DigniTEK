<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PublicacionTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idpublicacion');
        $this->addBehavior('Timestamp');
    }  

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('titulo')
            ->notEmpty('titulo')

            ->requirePresence('descripcion')
            ->notEmpty('descripcion');           
            
        return $validator;
    }      
}
?>