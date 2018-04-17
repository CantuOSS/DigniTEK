<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr') ?>
    <?= $this->element('media_viewer_scr') ?>
</head>
<body>
    <?= $this->element('navbar') ?>    
    <?= $this->element('titulo') ?>    
    <?= $this->Flash->render() ?>
    <?= $this->element('comunidad/comunidad_cont') ?>        
    <?= $this->element('comunidad/comunidad_herramientas') ?>        
</body>
<?= $this->element('footer') ?>    
<?= $this->element('footscr') ?>
<?= $this->element('comunidad/comunidad_script') ?>
<?= $this->element('menu_activo_scr') ?>
<?= $this->element('galeria_scr') ?>
</html>