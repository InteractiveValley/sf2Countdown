define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var FacturacionModel = Backbone.Model.extend({
                urlRoot: app.root + "/facturacion",
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
            return FacturacionModel;
        });
