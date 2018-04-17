<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr') ?>    
</head>
<body>
    <?= $this->element('navbar') ?>    
    <?= $this->element('titulo') ?> 
    <?= $this->Flash->render() ?>
    <?= $this->element('tek/tek_cont') ?> 
    <?= $this->element('tek/tek_herramientas') ?> 
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>
    <?= $this->element('datatables_scr') ?>
    <?= $this->element('tek/tek_script') ?>    
    <?= $this->element('menu_activo_scr') ?>
</html>