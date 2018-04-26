<?php
namespace App\Model\Table;

use Cake\ORM\Query;
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

    public function findPropietario(Query $query, array $options)
    {
        $user = $options['usuario'];
        $post = $options['post'];
        $res = $this->find('all')->where(['idproducto' => $post, 'usuario_idusuario' => $user['idusuario']]);
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