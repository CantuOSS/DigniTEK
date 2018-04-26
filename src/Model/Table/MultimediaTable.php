<?php
namespace App\Model\Table;

use Cake\ORM\Table;

class MultimediaTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idmultimedia');
        $this->addBehavior('Timestamp');
    }  
}
?>