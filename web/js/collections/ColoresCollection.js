define([
    'underscore', 
    'Backbone',
    'models/ColorModel'
],
    function ( _, Backbone, ColorModel ) {
        var ColoresCollection = Backbone.Collection.extend({
            url: app.root + "/colores",
            model: ColorModel
        });
        return ColoresCollection;
});

