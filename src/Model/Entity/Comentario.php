<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Comentario extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => true,
    ];
}
?>