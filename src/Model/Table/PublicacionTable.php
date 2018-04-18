<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class PublicacionTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idpublicacion');
        $this->addBehavior('Timestamp');
    }  
}