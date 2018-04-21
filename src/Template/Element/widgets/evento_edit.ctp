<div class="panel panel-default">
  <div class="panel-heading">Datos del Evento</div>
  <div class="panel-body">      
        <?php
          $myTemplates = [
              'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
              'textarea' => '<textarea class="form-control" style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>',
              'select' => '<select class="form-control" name="{{name}}"{{attrs}}>{{content}}</select>',
              'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>'
          ];
        ?>
        <?php echo $this->Form->create($evento, ['type' => 'file', 'id' => 'formarch']);?>
        <?php $this->Form->setTemplates($myTemplates);    ?>
        <div class="form-group">
          <?php echo $this->Form->input('titulo');    ?>
        </div>
        <div class="form-group">
        <label for="descripcion">Descripcion</label>
          <?php echo $this->Form->textarea('descripcion');    ?>
        </div>
        <div class="form-group">        
            <?php echo $this->Form->datetime('inicio');?>
            <!--<label for="fechasel">Fecha y hora</label>-->
            <!--<input size="16" type="text" value="2012-06-15 14:45" name="fechasel" readonly class="form_datetime form-control">-->
        </div>        
        <div class="form-group">
          <?php echo $this->Form->input('latitud');    ?>
        </div>        
        <div class="form-group">
          <?php echo $this->Form->input('longitud');    ?>
        </div>        
        <div class="form-group">
          <?php echo $this->Form->input('image_path[]', ['type' => 'file', 'multiple' => 'false', 'label' => 'Imagen del evento']);?>
        </div>         
        <?php echo $this->Form->button(__('Guardar'));?>
        <?php echo $this->Form->end();?>

  </div>  
</div>