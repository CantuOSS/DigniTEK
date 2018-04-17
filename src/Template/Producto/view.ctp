<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr') ?>    
    <?= $this->element('media_viewer_scr') ?>
</head>
<body>
    <?= $this->element('navbar') ?>    
    <?= $this->element('titulo') ?> 
    <br>
    <?= $this->Flash->render() ?>    
    <?= $this->element('productos/ver/producto_ver_cont') ?>
    <?= $this->element('productos/ver/producto_ver_herramientas') ?>  
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>
    <?= $this->element('datatables_scr') ?>
    <?= $this->element('galeria_scr') ?>  
    <?= $this->element('menu_activo_scr') ?>  
</html>