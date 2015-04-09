define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var EnvioModel = Backbone.Model.extend({
                urlRoot: app.root + "/envio",
                defaults: {
                    'calle': '',
                    'numExterior': '',
                    'numInterior': '',
                    'cp': '',
                    'municipio': '',
                    'colonia': '',
                    'estado': ''
                }
            });
            return EnvioModel;
        });
