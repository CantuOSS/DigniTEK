<script> 
    jQuery(function($){
        $('.table').footable({
            "columns": [
                        {"type": "object","title":"Imagen", "name":"imagen", "formatter": function(value){
                            if (value){
                                if (value.existe){
                                    return '<img class="img-fluid" style="height: 100px; width: 100px;" src="/DigniTEK/uploads/files/producto/' + value.id + "/" + value.enlace +'"/>';
                                } else {
                                    return '<img class="img-fluid" style="height: 100px; width: 100px;" src="/DigniTEK/img/placeholder.png"/>';
                                }
                            }
                            return "";
                        }},
                        {"name":"nombre","title":"Producto"},                            
                        {"name":"precio","title":"Precio","breakpoints":"xs sm"},
                        {"type": "object","title":"Ver", "name":"detalle", "formatter": function(value){
                        if (value){                                        
                            return '<a href= "' + value.enlace + '"  class="btn btn-info" role="button">Ver</a>';
                        }
                        return "";
                        }}
                        ],
		    "rows": $.get('/DigniTEK/producto/listaproductos')                
        });
    });        
</script>