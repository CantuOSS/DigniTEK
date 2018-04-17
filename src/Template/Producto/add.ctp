<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr') ?>    
</head>
<body>
    <?= $this->element('navbar') ?>    
    <?= $this->element('titulo') ?> 
    <br>
    <?= $this->Flash->render() ?>
    <?= $this->element('productos/add/producto_add_cont') ?> 
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>   
    <?= $this->element('menu_activo_scr') ?>
</html>