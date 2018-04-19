<script>
$(document).ready(function(){
    $('.img_gal').click(function(){
        console.log("click en imagen: " + $(this).attr('src'));
        $.magnificPopup.open({
            items: {
                src: $(this).attr('src')
            },
            type: 'image'
        });         
    });
});
</script>