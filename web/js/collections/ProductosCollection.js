define([
    'underscore', 
    'Backbone',
    'models/ProductoModel'
],
    function ( _, Backbone, ProductoModel ) {
        var ProductosCollection = Backbone.Collection.extend({
            url: app.root + "/productos",
            model: ProductoModel
        });
        return ProductosCollection;
});

