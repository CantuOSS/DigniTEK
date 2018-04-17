<div class="panel panel-default">
  <div class="panel-heading">Iniciar sesion</div>
  <div class="panel-body">
    <?= $this->Form->create('Usuario') ?>
    <?php
        $this->Form->setTemplates([
            'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
            'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>',
            'select' => '<select name="{{name}}"{{attrs}} class="form-control">{{content}}</select>'
        ]);
    ?>
        <div class="form-group">
            <?php echo $this->Form->input('username');?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->input('password');?>
        </div>
        <div class="form-group">
            <?php echo $this->Form->button('Iniciar sesion');?>
        </div>        
    <?php echo $this->Form->end();?>
  </div>
</div>