<div class="panel panel-default">
  <div class="panel-heading">Datos del Evento</div>
  <div class="panel-body">      
      <?php
        $myTemplates = [
            'input' => '<input readonly type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
            'textarea' => '<textarea readonly class="form-control" style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>',
            'select' => '<select readonly class="form-control" name="{{name}}"{{attrs}}>{{content}}</select>'
        ];
      ?>
        <?php $this->Form->create($evento);?>
        <?php $this->Form->setTemplates($myTemplates);    ?>
        <div class="form-group">
          <?php echo $this->Form->input('titulo');    ?>
        </div>
        <div class="form-group">
        <label for="descripcion">Descripcion</label>
          <?php echo $this->Form->textarea('descripcion');    ?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('inicio');    ?>
        </div>        
        <div class="form-group">
          <?php echo $this->Form->input('latitud');    ?>
        </div>        
        <div class="form-group">
          <?php echo $this->Form->input('longitud');    ?>
        </div>                
        <?php echo $this->Form->end();?>

  </div>  
</div>