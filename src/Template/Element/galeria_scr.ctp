<script type="text/javascript">
    var myViewer_0 = new ax5.ui.mediaViewer({
        target: $("#media-viewer-target-0"),
        loading: {
            icon: '<i class="fa fa-spinner fa-pulse fa-2x fa-fw margin-bottom" aria-hidden="true"></i>',
            text: '<div>Cargando</div>'
        },
        media: {
            prevHandle: '<i class="fa fa-chevron-left"></i>',
            nextHandle: '<i class="fa fa-chevron-right"></i>',
            width: 50, height: 50,
            poster: '<i class="fa fa-youtube-play" style="line-height: 46px;font-size: 20px;"></i>'
        },
        onClick: function () {
            console.log(this);
        }
    });

    $.ajax({
        url: "/DigniTEK/<?php echo $modulo ?>/medios"
        }).done(function(data) {
            console.log(data);
            myViewer_0.setMediaList(data);
    });
</script>