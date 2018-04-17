<!-- File: src/Template/Articles/edit.ctp -->

<h1>Edit Article</h1>
<?php
    echo $this->Form->create($article);
    echo $this->Form->control('id', ['type' => 'hidden']);
    echo $this->Form->control('titulo');
    echo $this->Form->control('contenido', ['rows' => '3']);
    echo $this->Form->date('fecha');
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>