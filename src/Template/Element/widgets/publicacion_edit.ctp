<div class="panel panel-default">
  <div class="panel-heading">Datos de la Publicacion</div>
  <div class="panel-body">      
      <?php
        $myTemplates = [
            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
            'textarea' => '<textarea class="form-control" style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>',
            'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>'
        ];
      ?>
        <?php echo $this->Form->create($publicacion, ['type' => 'file', 'id' => 'formarch']);?>
        <?php $this->Form->setTemplates($myTemplates);    ?>
        <div class="form-group">
          <?php echo $this->Form->input('titulo');    ?>
        </div>
        <div class="form-group">
        <label for="descripcion">Descripcion</label>
          <?php echo $this->Form->textarea('descripcion');    ?>
        </div>         
        <div class="form-group">
          <?php echo $this->Form->input('image_path[]', ['type' => 'file', 'multiple' => 'false', 'label' => 'Imagen de la publicacion']);?>
        </div>          
        <?php echo $this->Form->button(__('Guardar'));?>
        <?php echo $this->Form->end();?>

  </div>  
</div>