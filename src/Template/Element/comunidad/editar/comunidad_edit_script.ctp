<script>
      var map;
      var marker;
      function initMap() {
        <?php if ($comunidad->latitud == null && $comunidad->longitud == null) { ?>
          var uluru = {lat: 22.829208, lng: -106.6276705};
          var zoom = 6;
        <?php } else { ?>
          var uluru = {lat: <?php echo $comunidad->latitud ?>, lng: <?php echo $comunidad->longitud ?>};
          var zoom = 15;
        <?php }?>
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: zoom,
          center: uluru
        });
        marker = new google.maps.Marker({
            map: map,
            draggable: true
        });   
        marker.setMap(map);     
        <?php if ($comunidad->latitud != null && $comunidad->longitud != null) { ?>
          marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
          });
        <?php }?>
        map.addListener('click', function(e) {
          deleteMarkers()
          placeMarkerAndPanTo(e.latLng, map);
        });
        google.maps.event.addListener(marker,'dragend',function(event) {
          //document.getElementById('lat').value = this.position.lat();
          //document.getElementById('lng').value = this.position.lng();
          actualizarUbicacion(this.position);
        });        
        function placeMarkerAndPanTo(latLng, map) {
          markertmp = new google.maps.Marker({
            position: latLng,
            map: map,
            draggable: true
          });
          //google.maps.event.addListener(markertmp, 'click', function(event){
          //  console.log(event.latLng.lat() + ', ' + event.latLng.lng());         
          //});            
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
        // Sets the map on all markers in the array.
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
      /*
      $('#formarch').off().on('submit', function(e){
        e.preventDefault();
        var formdatas = new FormData($('#formarch')[0]);
        $.ajax({
            url: '/DigniTEK/comunidad/edit',
            dataType: 'json',
            method: 'post',
            data:  formdatas,
            xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
            },            
            contentType: false,
            processData: false
        })
            .done(function(response) {
                console.log(response);
                //show result
                if (response.status == 'OK') {                  
                } else if (response.status == 'FAIL') {

                } else {
                    //show default message
                }
            })
            .fail(function(jqXHR) {
                if (jqXHR.status == 403) {
                    window.location = '/';
                } else {
                    console.log(jqXHR);

                }
            });

      });    

      function progress(e){

        if(e.lengthComputable){
            var max = e.total;
            var current = e.loaded;

            var Percentage = (current * 100)/max;
            console.log(Percentage);


            if(Percentage >= 100)
            {
              // process completed  
            }
        }  
    }      */  
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA4ZNehyBtk5I-Cz85Qin66e_rM32ShqPM&callback=initMap">
</script>


