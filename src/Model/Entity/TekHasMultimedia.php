<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class TekHasMultimedia extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => true,
    ];
}
?>