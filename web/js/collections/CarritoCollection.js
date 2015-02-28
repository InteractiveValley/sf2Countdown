define([
    'underscore', 
    'Backbone',
    'models/ProductoModel'
],
    function ( _, Backbone, ProductoModel ) {
        var CarritoCollection = Backbone.Collection.extend({
            url: app.root + "/productos",
            model: ProductoModel,
            defaults:{
				total: 0.0,
				descuento: 0.0,
				cuantos: 0
			},
            getTotalesCarrito: function(){
                this.total =0.0;
                this.descuento = 0.0;
                this.cuantos = 0;
                var self = this;
                this.each(function(producto){
                   self.cuantos += producto.get('cantidad');
                   self.total += producto.get('importe'); 
                });
                this.descuento = Math.ceil(this.cuantos/3)*100;
                return this.getFormateadosTotales();
            },
            getFormateadosTotales: function(){
                var self = this;
				return {
                    total: formatNumber.new(self.total,"$"),
                    descuento: formatNumber.new(self.descuento,"$"),
                    cuantos: formatNumber.new(self.cuantos,"")
                };
            }
        });
        return CarritoCollection;
});

