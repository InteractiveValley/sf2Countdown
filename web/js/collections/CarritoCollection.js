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
                carrito: {},
            },
            getTotalesCarrito: function(){
                this.carrito.total =0.0;
                this.carrito.descuento = 0.0;
                this.carrito.cuantos = 0;
                var self = this;
                this.each(function(producto){
                   self.carrito.cuantos += producto.get('cantidad');
                   self.carrito.total += producto.get('importe'); 
                });
                this.carrito.descuento = Math.ceil(carrito.cuantos/3)*100;
                return this.getFormateadosTotales();
            },
            getFormateadosTotales: function(){
                var self = this;
		return {
                    total: formatNumber.new(self.carrito.total,"$"),
                    descuento: formatNumber.new(self.carrito.descuento,"$"),
                    cuantos: formatNumber.new(self.carrito.cuantos,"")
                };
            }
        });
        return CarritoCollection;
});

