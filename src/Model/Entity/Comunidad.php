<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Comunidad extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => true,
    ];
}