<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr') ?>    
</head>
<body>
    <?= $this->element('navbar') ?>    
    <?= $this->element('titulo') ?> 
    <?= $this->Flash->render() ?>
    <?= $this->element('productos/productos_cont') ?> 
    <?= $this->element('productos/productos_herramientas') ?> 
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>
    <?= $this->element('datatables_scr') ?>
    <?= $this->element('productos/productos_script') ?>
    <?= $this->element('menu_activo_scr') ?>    
</html>