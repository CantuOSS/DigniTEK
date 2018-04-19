<div class="panel panel-default">
  <div class="panel-heading">Datos del TEK</div>
  <div class="panel-body">
    <?php echo $this->Form->create($tek, ['type' => 'file', 'id' => 'formarch']) ?>
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
            <label for="categoria_tek_idcategoria_tek">Categoria</label>
            <?php echo $this->Form->input('categoria_tek_idcategoria_tek', ['type' => 'select', 'options' => $categorias, 'empty' => __('Selecciona una categoria'), 'label' => false, 'default' => $tek->categoria_tek_idcategoria_tek]) ?>
        </div>        
        <div class="form-group">
            <label for="descripcion">Descripcion</label>
            <?php echo $this->Form->textarea('descripcion');?>
        </div>                     
        <div class="form-group">
            <?php echo $this->Form->input('image_path[]', ['type' => 'file', 'multiple' => 'false', 'label' => 'Imagen del TEK']);?>
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