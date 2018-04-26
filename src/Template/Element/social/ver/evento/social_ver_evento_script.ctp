<script>
  function initMap() {
    <?php if ($evento->latitud == null && $evento->longitud == null) { ?>
      var uluru = {lat: 22.829208, lng: -106.6276705};
      var zoom = 6;          
    <?php } else { ?>
      var uluru = {lat: <?php echo $evento->latitud ?>, lng: <?php echo $evento->longitud ?>};
      var zoom = 15;
    <?php }?>
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: zoom,
      center: uluru
    });
    <?php if ($evento->latitud != null && $evento->longitud != null) { ?>
      var marker = new google.maps.Marker({
        position: uluru,
        map: map
      });
    <?php }?>
  }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4ZNehyBtk5I-Cz85Qin66e_rM32ShqPM&callback=initMap">
</script>