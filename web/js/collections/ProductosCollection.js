define([
    'underscore', 
    'Backbone',
    'models/ProductoModel'
],
    function ( _, Backbone, ProductoModel ) {
        var ProductosCollection = Backbone.Collection.extend({
            url: app.root + "/productos",
            model: ProductoModel,
            parse: function(data){
                return data.productos;
            }
        });
        return ProductosCollection;
});

