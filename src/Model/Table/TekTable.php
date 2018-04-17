<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class TekTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idtek');
    }  
}