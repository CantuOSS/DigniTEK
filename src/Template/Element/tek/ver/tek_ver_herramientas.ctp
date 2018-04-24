<?php if ($tek->usuario_idusuario == $idusuario_nav){ ?>
<nav class=" navbar-inverse navbar-fixed-bottom navbar-dark bg-dark">
<div class="container-fluid">
  <ul class="nav navbar-nav">    
    <li><a href="/DigniTEK/tek/edit/<?php echo $tek->idtek ?>">
        <i class="fa fa-plus-circle"></i>
        Modificar TEK
    </a></li>
  </ul>
</div>
</nav> 
<?php } ?>