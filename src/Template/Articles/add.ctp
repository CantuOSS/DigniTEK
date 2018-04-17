<!-- File: src/Template/Articles/add.ctp -->

<h1>Add Article</h1>
<?php
    echo $this->Form->create($article);
    // Hard code the user for now.
    //echo $this->Form->control('id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('titulo');
    echo $this->Form->control('contenido', ['rows' => '3']);
    echo $this->Form->date('fecha');
    echo $this->Form->button(__('Save Article'));
    echo $this->Form->end();
?>