<!DOCTYPE html>
<html lang="es">
<head>
    <?= $this->element('headscr')?>    
</head>
<body>
    <?= $this->element('navbar')?>    
    <?= $this->element('titulo')?>    
    <br>
    <?= $this->Flash->render()?>
    <?= $this->element('comunidad/editar/comunidad_edit_cont')?> 
</body>
<?= $this->element('footer')?>    
<?= $this->element('footscr')?>
<?= $this->element('comunidad/editar/comunidad_edit_script')?>
<?= $this->element('menu_activo_scr')?>
</html>