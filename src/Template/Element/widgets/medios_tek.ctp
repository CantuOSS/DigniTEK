<div class="panel panel-default">
  <div class="panel-heading">Medios</div>
  <div class="panel-body">
    <div class="row">
        <?php if (!empty($medios)){ ?>
            <?php foreach($medios as $medio){ ?>
                <div class="col-sm-12">
                    <div class="col-sm-12 col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">Imagen</div>
                            <div class="panel-body">                
                                <img class="img-responsive img_gal" src="<?= $medio->ruta?>">    
                                <br>    
                                <?php 
                                    if (!empty($editar) && $editar == true){
                                        $this->Form->setTemplates([                                        
                                            'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>'
                                        ]);                                   
                                        echo $this->Form->postButton('Eliminar multimedia', ['controller' => 'Tek', 'action' => 'elimmedios', $medio->idmultimedia]); 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Descripcion</div>
                            <div class="panel-body">        
                            <?php echo $this->Form->create($medio, ['url' => ['action' => 'editmedios']]); 
                                if (!empty($editar) && $editar == false){
                                $this->Form->setTemplates([
                                    'textarea' => '<textarea readonly style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>',
                                    'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>'
                                ]);    
                                } else {
                                    $this->Form->setTemplates([
                                        'textarea' => '<textarea style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>',
                                        'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>'
                                    ]);   
                                }
                            ?>                                   
                                <?php echo $this->Form->textarea('descripcion');?>
                                <?php if (!empty($editar) && $editar == true){
                                        echo $this->Form->button(__('Actualizar'));                                        
                                    }
                                ?>
                            <?php echo $this->Form->end();?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php }?>
    </div>
  </div>
</div>