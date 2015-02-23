define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var ProductoModel = Backbone.Model.extend({
                urlRoot: app.root + "/productos",
                defaults: {
                    'nombre': '',
                    cantidad: 0,
                    importe: 0,
                    importe_with_format: '',
                    cantidad_with_format: '',
                    precio_with_format: ''
                },
                initialize: function () {
                    this.on("change:cantidad", function (self) {
                        self.set({importe_with_format: this.getImporteFormat()});
                        self.set({cantidad_with_format: this.getCantidadFormat()});
                     });
                    this.set({precio_with_format: this.getPrecioFormat()});
                },
                getImporteFormat: function(){
                    this.set({importe: this.get('precio')*this.get('cantidad')});
                    return formatNumber.new(this.get('importe'),"$");
                },
                getPrecioFormat: function(){
                    return formatNumber.new(this.get('precio'),"$");
                },
                getCantidadFormat: function(){
                    return formatNumber.new(this.get('cantidad'),"");
                }
            });
            return ProductoModel;
        }
);
