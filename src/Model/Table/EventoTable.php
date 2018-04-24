<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class EventoTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idevento');
        $this->addBehavior('Timestamp');
    }  
}
?>