<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">Comentarios</div>
                <div class="panel-body" style="padding:30px;"> 
                    <?php foreach($comentarios as $comentario) { ?>
                        <div class="row" style="border-width:1px;border-color:black;border-style:solid;border-radius:5px;padding:10px;">
                            <div class="col-sm-12 col-md-4" align="center">
                                <?php echo $this->Html->image('usuario.png', ['alt' => 'Usuario', 'class' => 'img-responsive', 'style' => 'width:100px;']);?>        
                                <?=$comentario->usuario?>
                                <?=$comentario->created?>
                            </div>
                            <div class="col-sm-12 col-md-8" style="padding:10px;border-radius:5px;background:#8080801c;">
                                <?=$comentario->contenido?>
                            </div>
                        </div>
                        <br>
                    <?php } ?>

                    <!-- formulario para agregar comentario -->
                    <div class="row" style="border-width:1px;border-color:black;border-style:solid;border-radius:5px;padding:10px;">
                        <div class="col-sm-12 col-md-4" align="center">
                            <?php echo $this->Html->image('usuario.png', ['alt' => 'Usuario', 'class' => 'img-responsive', 'style' => 'width:100px;']);?>        
                            <?=$nombreusuario_nav?>
                            <p>Agregue un comentario</p>
                        </div>
                        <div class="col-sm-12 col-md-8" style="padding:10px;border-radius:5px;background:#8080801c;">
                            <?= $this->Form->create('Comentario', ['url' => ['action' => 'agregacomentario']]) ?>
                                <?php
                                    $this->Form->setTemplates([
                                        'input' => '<input type="{{type}}" name="{{name}}"{{attrs}} class="form-control"/>',
                                        'button' => '<button{{attrs}} class="btn btn-primary">{{text}}</button>',
                                        'select' => '<select name="{{name}}"{{attrs}} class="form-control">{{content}}</select>',
                                        'textarea' => '<textarea class="form-control" style="width:100%;" name="{{name}}"{{attrs}}>{{value}}</textarea>'
                                    ]);
                                ?>                            
                                <?php echo $this->Form->hidden('publicacion_idpublicacion', ['value' => $id]); ?>
                                <?php echo $this->Form->hidden('usuario_idusuario', ['value' => $idusuario_nav]); ?>
                                <div class="form-group">
                                    <label for="contenido">Contenido</label>
                                    <?php echo $this->Form->textarea('contenido');?>
                                </div>                                  
                                <?php echo $this->Form->button(__('Comentar'));?>
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>                       
                </div>             
            </div>
        </div>
    </div>    
</div>