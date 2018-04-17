<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
// the Text class
use Cake\Utility\Text;

use Cake\Validation\Validator;

class ArticlesTable extends Table
{
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
    }

    public function beforeSave($event, $entity, $options)
    {
        if ($entity->isNew() && !$entity->id) {
            $sluggedTitle = Text::slug($entity->titulo);
            // trim slug to maximum length defined in schema
            $entity->id = substr($sluggedTitle, 0, 191);
        }
    }    

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notEmpty('titulo')
            ->minLength('titulo', 10)
            ->maxLength('titulo', 255)
    
            ->notEmpty('contenido')
            ->minLength('contenido', 10)

            ->notEmpty('fecha');
    
        return $validator;
    }    
}