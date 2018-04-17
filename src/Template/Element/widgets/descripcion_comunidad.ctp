<div class="panel panel-default">
  <div class="panel-heading">Descripcion de la comunidad</div>
  <div class="panel-body">      
    <?php 
        $myTemplates = [
            'textarea' => '<textarea readonly style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>'
        ];
        $this->Form->create($comunidad);
        $this->Form->setTemplates($myTemplates);    
        echo $this->Form->textarea('descripcion');    
        echo $this->Form->end();
    ?>
  </div>
</div>