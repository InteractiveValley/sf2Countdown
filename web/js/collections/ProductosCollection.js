define([
    'underscore', 
    'Backbone',
    'models/ProductoModel'
],
    function ( _, Backbone, ProductoModel ) {
        var ProductosCollection = Backbone.Collection.extend({
            url: app.root + "/modelos",
            model: ProductoModel,
            filtrarPorPrecio: function(valor){
                var i = this.models.length-1;
                var visibleModel = true;
                for(; i>=0; i--){
                    visibleModel = (this.models[i].get('precio')<=valor)
                    this.models[i].set({'visible':visibleModel});
                }
            }
        });
        return ProductosCollection;
});

