<div class="panel panel-default">
<div class="panel-heading">Datos del producto</div>
<div class="panel-body">
  <?= $this->Form->create($producto,  ['type' => 'file', 'id' => 'formarch']) ?>
  <?php
      $this->Form->setTemplates([
          'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
          'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>',
          'select' => '<select name="{{name}}"{{attrs}} class="form-control">{{content}}</select>',
          'textarea' => '<textarea class="form-control" style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>'
      ]);
  ?>
    <div class="form-group">
        <?php echo $this->Form->input('nombre');?>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripcion</label>
        <?php echo $this->Form->textarea('descripcion');?>
    </div>  
    <div class="form-group">
        <?php echo $this->Form->input('precio');?>
    </div>                         
    <div class="form-group">
        <?php echo $this->Form->input('image_path[]', ['type' => 'file', 'multiple' => 'false', 'label' => 'Imagen del producto']);?>
    </div>          
    <?php if (!empty($editar) && $editar == true) {?>
            <div class="form-group">
                <?php echo $this->Form->input('multimedia[]', ['type' => 'file', 'multiple' => 'true', 'label' => 'Multimedia']);?>
            </div>           
    <?php } ?>    
    <?php echo $this->Form->button(__('Guardar'));?>
    <?php echo $this->Form->end();?>
</div>
</div>