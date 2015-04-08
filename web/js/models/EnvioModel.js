define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var EnvioModel = Backbone.Model.extend({
                urlRoot: app.root + "/envio",
                defaults: {
                    'tipoDireccion': 2,
                    'calle': '',
                    'numExterior': '',
                    'numInterior': '',
                    'cp': '',
                    'municipio': '',
                    'colonia': '',
                    'estado': '',
                    'contacto': '',
                    'paqueteria': ''
                }
            });
            return EnvioModel;
        });
