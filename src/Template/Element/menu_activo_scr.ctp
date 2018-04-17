<script>
    $(document).ready(function() {
        $('li.active').removeClass('active');
        $('li[id="<?= $activo ?>"]').addClass('active'); 
    });
</script>