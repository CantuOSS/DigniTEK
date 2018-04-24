<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ComunidadTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idcomunidad');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('nombre')
            ->notEmpty('nombre')

            ->requirePresence('descripcion')
            ->notEmpty('descripcion')       
            
            ->requirePresence('lengua')
            ->notEmpty('lengua');
        return $validator;
    }    
}
?>