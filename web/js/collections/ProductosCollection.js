define([
    'underscore', 
    'Backbone',
    'models/ProductoModel'
],
    function ( _, Backbone, ProductoModel ) {
        var ProductosCollection = Backbone.Collection.extend({
            url: app.root + "/modelos",
            model: ProductoModel
        });
        return ProductosCollection;
});

