<div class="panel panel-default">
  <div class="panel-heading">Datos del usuario</div>
  <div class="panel-body">
    <?= $this->Form->create($usuario) ?>
    <?php
        $this->Form->setTemplates([
            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
            'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>',
            'select' => '<select name="{{name}}"{{attrs}} class="form-control">{{content}}</select>'
        ]);
    ?>
        <div class="form-group">
            <?php echo $this->Form->input('nombre');?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('apellidos');?>
        </div>        
        <div class="form-group">
            <label for="nacimiento">Fecha de nacimiento</label>
            <?php echo $this->Form->date('nacimiento');?>
        </div>        
        <div class="form-group">
            <?php echo $this->Form->input('sexo', array('options' => array('masculino' => 'Masculino', 'femenino' => 'Femenino'), 'empty' => '','label' => 'Sexo'));?>
        </div>        
        <div class="form-group">
            <?php echo $this->Form->input('correo');?>
        </div>        
        <div class="form-group">
            <?php echo $this->Form->input('username');?>
        </div>        
        <div class="form-group">
            <label for="contra">Contraseña</label>
            <?php echo $this->Form->password('password');?>
        </div>                
        <div class="form-group">
            <?php echo $this->Form->input('rol', array('options' => array('contribuidor' => 'Contribuidor', 'coordinador' => 'Coordinador', 'traductor' => 'Traductor'), 'empty' => '','label' => 'Rol'));?>
        </div>                
        <?php echo $this->Form->button(__('Guardar Usuario'));?>
    <?php echo $this->Form->end();?>
  </div>
</div>