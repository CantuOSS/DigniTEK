<script>
  var map;
  var marker;
  function initMap() {
    <?php if ($evento->latitud == null && $evento->longitud == null) { ?>
      var uluru = {lat: 22.829208, lng: -106.6276705};
      var zoom = 6;
    <?php } else { ?>
      var uluru = {lat: <?php echo $evento->latitud ?>, lng: <?php echo $evento->longitud ?>};
      var zoom = 15;
    <?php }?>
    map = new google.maps.Map(document.getElementById('map'), {
      zoom: zoom,
      center: uluru
    });
    marker = new google.maps.Marker({
        map: map,
        draggable: false
    });   
    marker.setMap(map);     
    <?php if ($evento->latitud != null && $evento->longitud != null) { ?>
      marker = new google.maps.Marker({
        position: uluru,
        map: map,
        draggable: false
      });
    <?php }?>
    map.addListener('click', function(e) {
      deleteMarkers();
      placeMarkerAndPanTo(e.latLng, map);
    });
    google.maps.event.addListener(marker,'dragend',function(event) {
      deleteMarkers();
      placeMarkerAndPanTo(event.latLng, map);
    });        
    function placeMarkerAndPanTo(latLng, map) {
      markertmp = new google.maps.Marker({
        position: latLng,
        map: map,
        draggable: false
      });           
      actualizarUbicacion(latLng);
      map.panTo(latLng);
      marker = markertmp;
    }   
    function deleteMarkers() {
      clearMarkers();
      marker = null;
    }  
    function clearMarkers() {
      setMapOnAll(null);
    }        
    function setMapOnAll(map) {
      marker.setMap(map);
    }         
    function actualizarUbicacion(dato){
      if (dato != null){
        console.log(dato.lat() + ', ' + dato.lng()); 
        document.getElementById("latitud").value = dato.lat();            
        document.getElementById("longitud").value = dato.lng();            
      }   
    }
  }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4ZNehyBtk5I-Cz85Qin66e_rM32ShqPM&callback=initMap">
</script>
