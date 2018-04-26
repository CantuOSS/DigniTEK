<?php
namespace App\Model\Table;

use Cake\ORM\Query;
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

    public function findPropietario(Query $query, array $options)
    {
        $user = $options['usuario'];
        $post = $options['post'];
        $res = $this->find('all')->where(['idpublicacion' => $post, 'usuario_idusuario' => $user['idusuario']]);
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