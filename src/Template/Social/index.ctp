<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr') ?>    
</head>
<body>
    <?= $this->element('navbar') ?>    
    <?= $this->element('titulo') ?> 
    <?= $this->Flash->render() ?>
    <?= $this->element('social/social_cont') ?> 
    <?= $this->element('social/social_herramientas') ?> 
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>
    <?= $this->element('datatables_scr') ?>
    <?= $this->element('social/social_script') ?>
    <?= $this->element('menu_activo_scr') ?>    
</html>