<div class="panel panel-default">
    <div class="panel-heading">
        <h4>Perfil de usuario</h4>     
    <div class="panel-body">
    <div class="row">
                <div class="col-xs-12 col-md-3 col-lg-3 " align="center"> <?php echo $this->Html->image('usuario.png', ['alt' => 'CakePHP', 'class' => 'img-responsive']);?> </div>
                
                <div class="col-xs-12 col-md-9 col-lg-9 ">                 
                
                  <table class="table">
                      <tr>
                        <td>Nombre:</td>
                        <td data-breakpoints="xs"><?php echo $usuario->nombre ?></td>
                      </tr>
                      <tr>
                        <td>Apellidos:</td>
                        <td data-breakpoints="xs"><?php echo $usuario->apellidos ?></td>
                      </tr>
                      <tr>
                        <td>Fecha de nacimiento</td>
                        <td data-breakpoints="xs"><?php echo $usuario->nacimiento ?></td>
                      </tr>
                        <td>Sexo</td>
                        <td data-breakpoints="xs"><?php echo $usuario->sexo ?></td>
                      </tr>
                        <tr>
                        <td>Correo</td>
                        <td data-breakpoints="xs"><?php echo $usuario->correo ?></td>
                      </tr>
                      <tr>
                        <td>Usuario</td>
                        <td data-breakpoints="xs"><?php echo $usuario->username ?></td>
                      </tr>
                        <td>Rol</td>
                        <td data-breakpoints="xs"><?php echo $usuario->rol ?></td>                           
                      </tr>                      
                  </table>
                
                  
                  <a href="/DigniTEK/usuario/edit/<?php echo $usuario->idusuario ?>" class="btn btn-primary">Editar informacion</a>
                  
                </div>
              </div>
            </div>         
    </div>
</div>