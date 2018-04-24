<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class EventoTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idevento');
        $this->addBehavior('Timestamp');
    }  

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('titulo')
            ->notEmpty('titulo')

            ->requirePresence('descripcion')
            ->notEmpty('descripcion')              
            
            ->requirePresence('inicio')
            ->notEmpty('inicio');             
            
        return $validator;
    }      
    
    public function findPropietario(Query $query, array $options)
    {
        $user = $options['usuario'];
        $post = $options['post'];
        //$this->log("usuario valido para edicion: " . $user['idusuario'] . ", resultado: " . $query->where(['usuario_idusuario' => $user['idusuario']]), 'debug');
        $res = $this->find('all')->where(['idevento' => $post, 'usuario_idusuario' => $user['idusuario']]);
        $valido = false;
        $cont = 0;
        foreach($res as $inst){
            $cont++;
        }
        if ($cont == 1){
            return true;
        } else {
            return false;
        }
    }    
}
?>