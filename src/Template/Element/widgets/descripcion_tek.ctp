<div class="panel panel-default">
  <div class="panel-heading">Datos del TEK</div>
  <div class="panel-body">      
      <?php
        $myTemplates = [
            'input' => '<input readonly type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
            'textarea' => '<textarea readonly class="form-control" style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>'
        ];
      ?>
        <?php $this->Form->create($tek);?>
        <?php $this->Form->setTemplates($myTemplates);    ?>
        <div class="form-group">
          <?php echo $this->Form->input('nombre');    ?>
        </div>
        <div class="form-group">
        <label for="descripcion">Descripcion</label>
          <?php echo $this->Form->textarea('descripcion');    ?>
        </div>
        <div class="form-group">
          <?php echo $this->Form->input('categoria', ['default' => $categoria]);    ?>
        </div>          
        <?php echo $this->Form->end();?>

  </div>  
</div>