<script>
        FooTable.MyFiltering = FooTable.Filtering.extend({
            construct: function(instance){
                this._super(instance);
                this.statuses = ['Publicacion','Evento'];
                this.def = 'Todo';
                this.$status = null;
            },
            $create: function(){
                this._super();
                var self = this,
                    $form_grp = $('<div/>', {'class': 'form-group'})
                        .append($('<label/>', {'class': 'sr-only', text: 'Tipo'}))
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
                    self.addFilter('tipo', selected, ['tipo']);
                } else {
                    self.removeFilter('tipo');
                }
                self.filter();
            },
            draw: function(){
                this._super();
                var status = this.find('tipo');
                if (status instanceof FooTable.Filter){
                    this.$status.val(status.query.val());
                } else {
                    this.$status.val(this.def);
                }
            }
        });

        jQuery(function($){
            $('.table').footable({
                components: {
		            filtering: FooTable.MyFiltering
	            },                
                "columns": [
                            {"type": "object","title":"Imagen", "name":"imagen", "formatter": function(value){
                                    if (value){
                                        if (value.existe){
                                            return '<img class="img-fluid" style="height: 150px; width: 300px;" src="/DigniTEK/uploads/files/social/' + value.directorio + "/" + value.id + "/" + value.enlace +'"/>';
                                        } else {
                                            return '<img class="img-fluid" style="height: 150px; width: 300px;" src="/DigniTEK/img/placeholder.png"/>';
                                        }
                                    }
                                    return "";
                            }},
                            {"name":"titulo","title":"Titulo"},
                            {"name":"tipo","title":"Tipo"},                            
                            {"name":"fecha","title":"Fecha","breakpoints":"xs sm",
                            "formatter": function(value){
                                moment.locale('es'); 
                                return moment(value).format('MMMM D YYYY - h:mm');}
                            },                        
                            {"name":"comentarios","title":"Comentarios","breakpoints":"xs sm"},
                            {"type": "object","title":"Ver", "name":"detalle","breakpoints":"xs sm", "formatter": function(value){
                                    if (value){                                        
                                        return '<a href= "' + value.enlace + '"  class="btn btn-info" role="button">Ver</a>';
                                    }
                                    return "";
                            }}
                            ],
		        "rows": $.get('/DigniTEK/social/listasocial')                
            });
        });        
</script>