<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

class TekTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idtek');
        $this->addBehavior('Timestamp');
    }  


    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('nombre')
            ->notEmpty('nombre')

            ->requirePresence('descripcion')
            ->notEmpty('descripcion')     

            ->requirePresence('categoria_tek_idcategoria_tek')
            ->notEmpty('categoria_tek_idcategoria_tek');     
                            
        return $validator;
    }    

    public function findPropietario(Query $query, array $options)
    {
        $user = $options['usuario'];
        $post = $options['post'];
        $res = $this->find('all')->where(['idtek' => $post, 'usuario_idusuario' => $user['idusuario']]);
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