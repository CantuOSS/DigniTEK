<div class="panel panel-default">
  <div class="panel-heading">Datos de la comunidad</div>
  <div class="panel-body">
    <?= $this->Form->create($comunidad, ['type' => 'file', 'id' => 'formarch']) ?>
    <?php
        $this->Form->setTemplates([
            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
            'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>',
            'textarea' => '<textarea style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>'
        ]);
    ?>
        <div class="form-group">
            <?php echo $this->Form->input('nombre');?>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripcion de la comunidad (max. 1000 caracteres)</label>
            <?php echo $this->Form->textarea('descripcion');?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('lengua');?>
        </div>        
        <div class="form-group">
            <?= $this->element('widgets/ubicacion_comunidad') ?>        
            <?php echo $this->Form->input('latitud');?>
            <?php echo $this->Form->input('longitud');?>
        </div> 
        <div class="form-group">
            <?php echo $this->Form->input('image_path[]', ['type' => 'file', 'multiple' => 'false', 'label' => 'Imagen de la comunidad']);?>
        </div> 
        <?php echo $this->Form->button(__('Guardar'));?>
    <?php echo $this->Form->end();?>
  </div>
</div>