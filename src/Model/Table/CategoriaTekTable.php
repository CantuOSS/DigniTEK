<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class CategoriaTekTable extends Table
{
    public function initialize(array $config)
    {
        $this->setPrimaryKey('idcategoria_tek');
        $this->setDisplayField('nombre');
    }  
}