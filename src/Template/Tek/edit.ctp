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
    <?= $this->element('tek/editar/tek_edit_cont') ?> 
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>   
    <?= $this->element('magnific_popup_scr') ?>    
    <?= $this->element('menu_activo_scr') ?>
</html>