<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class CategoriaTek extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => true,
    ];
}
?>