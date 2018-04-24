<?php
if ($tipo == "publicacion"){
  $contenido = $publicacion;
} else {
  $contenido = $evento;
}
if ($contenido->usuario_idusuario == $idusuario_nav){ ?>
<nav class=" navbar-inverse navbar-fixed-bottom navbar-dark bg-dark">
<div class="container-fluid">
  <ul class="nav navbar-nav">    
    <li><a href="/DigniTEK/social/edit/<?php echo $tipo ?>/<?php echo $id ?>/">
        <i class="fa fa-plus-circle"></i>
        Editar contenido
    </a></li>
  </ul>
</div>
</nav> 
<?php } ?>