define([
    'underscore',
    'Backbone'
],
        function (_, Backbone) {
            var UsuarioModel = Backbone.Model.extend({
                urlRoot: app.root + "/usuario",
                defaults: {
                    'nombre': '',
                    'usuario': '',
                    'password': ''
                }
            });
            return UsuarioModel;
        });
