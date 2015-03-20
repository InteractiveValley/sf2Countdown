define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var FiltroPrecioModel = Backbone.Model.extend({
                defaults: {
                    value: 2000,
                },
            });
            return FiltroPrecioModel;
        }
);
