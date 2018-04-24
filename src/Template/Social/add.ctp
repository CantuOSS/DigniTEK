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
    <?= $this->element('social/add/' . $tipo . '/social_add_' . $tipo . '_cont') ?>     
</body>
    <?= $this->element('footer') ?>    
    <?= $this->element('footscr') ?>
    <?= $this->element('datatables_scr') ?>    
    <?= $this->element('social/add/' . $tipo . '/social_add_' . $tipo . '_script') ?>         
    <?= $this->element('menu_activo_scr') ?>
</html>