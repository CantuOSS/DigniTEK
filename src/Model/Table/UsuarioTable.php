<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsuarioTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idusuario');
        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('nombre')
            ->notEmpty('nombre')

            ->requirePresence('apellidos')
            ->notEmpty('apellidos')       
            
            ->requirePresence('nacimiento')
            ->notEmpty('nacimiento')        
            
            ->requirePresence('sexo')
            ->notEmpty('sexo')     
            
            ->requirePresence('correo')
            ->notEmpty('correo')         
            
            ->requirePresence('username')
            ->notEmpty('username')         
            
            ->requirePresence('password')
            ->notEmpty('password')         
            
            ->requirePresence('rol')
            ->notEmpty('rol');                     
        return $validator;
    }    
}
?>