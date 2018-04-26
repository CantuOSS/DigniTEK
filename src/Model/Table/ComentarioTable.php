<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class ComentarioTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idcomentario');    
        $this->addBehavior('Timestamp');    
    }  
}
?>