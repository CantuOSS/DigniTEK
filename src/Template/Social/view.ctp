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
    <?= $this->element('social/ver/' . $tipo . '/social_ver_' . $tipo . '_cont') ?>   
    <?= $this->element('social/ver/social_ver_herramientas') ?>   
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>
    <?= $this->element('datatables_scr') ?>
    <?= $this->element('galeria_social_src') ?>
    
    <?= $this->element('social/ver/' . $tipo . '/social_ver_' . $tipo . '_script') ?>         
    <?= $this->element('menu_activo_scr') ?>
</html>