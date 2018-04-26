<?php if ($producto->usuario_idusuario == $idusuario_nav){ ?>
  <nav class=" navbar-inverse navbar-fixed-bottom navbar-dark bg-dark">
    <div class="container-fluid">
      <ul class="nav navbar-nav">    
        <li><a href="/DigniTEK/producto/edit/<?php echo $producto->idproducto ?>">
            <i class="fa fa-plus-circle"></i>
            Modificar Producto
        </a></li>
      </ul>
    </div>
  </nav> 
<?php } ?>