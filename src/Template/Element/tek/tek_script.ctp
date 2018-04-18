<script>
        FooTable.MyFiltering = FooTable.Filtering.extend({
            construct: function(instance){
                this._super(instance);
                this.statuses = ["Historias orales, tradiciones y leyendas","Ceremonias y costumbres","Discursos cotidianos y oratoria","Sue\u00f1os y visiones","Ense\u00f1anza y aprendizaje experimental","Principios ecol\u00f3gicos e indicadores","Modificacion del entorno","Inventariado y monitoreo","Estrategias de cosecha","Adaptabilidad","Conocimiento del clima y las temporadas","Conocimiento del entorno","Clasificacion y nomenclatura"];
                this.def = 'Todo';
                this.$status = null;
            },
            $create: function(){
                this._super();
                var self = this,
                    $form_grp = $('<div/>', {'class': 'form-group'})
                        .append($('<label/>', {'class': 'sr-only', text: 'Categoria'}))
                        .prependTo(self.$form);

                self.$status = $('<select/>', { 'class': 'form-control' })
                    .on('change', {self: self}, self._onStatusDropdownChanged)
                    .append($('<option/>', {text: self.def}))
                    .appendTo($form_grp);

                $.each(self.statuses, function(i, status){
                    self.$status.append($('<option/>').text(status));
                });
            },
            _onStatusDropdownChanged: function(e){
                var self = e.data.self,
                    selected = $(this).val();
                if (selected !== self.def){
                    self.addFilter('categoria', selected, ['categoria']);
                } else {
                    self.removeFilter('categoria');
                }
                self.filter();
            },
            draw: function(){
                this._super();
                var status = this.find('categoria');
                if (status instanceof FooTable.Filter){
                    this.$status.val(status.query.val());
                } else {
                    this.$status.val(this.def);
                }
            }
        }); 
        jQuery(function($){
            $('.table').footable({
                "components": {
		            filtering: FooTable.MyFiltering
	            },                 
                "columns": [
                            {"type": "object","title":"Imagen", "name":"imagen", "formatter": function(value){
                                    if (value){
                                        return '<img class="img-fluid" style="height: 150px; width: 300px;" src="/DigniTEK/uploads/files/tek/' + value.id + "/" + value.enlace +'"/>';
                                    }
                                    return "";
                            }},                                                
                            {"name":"nombre","title":"Nombre"},
                            {"name":"descripcion","title":"Descripcion","breakpoints":"xs sm"},   
                            {"name":"categoria","title":"Categoria","breakpoints":"xs sm"},   
                            {"name":"modified","title":"Fecha","breakpoints":"xs sm"},
                            {"type": "object","title":"Ver", "name":"detalle", "formatter": function(value){
                                    if (value){                                        
                                        return '<a href= "' + value.enlace + '"  class="btn btn-info" role="button">Ver</a>';
                                    }
                                    return "";
                            }}
                            ],
		        "rows": $.get('/DigniTEK/tek/listatek')                
            });
        });        
</script>