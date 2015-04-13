define([
    'underscore',
    'backbone.validation'
],
        function (_, Backbone) {
            var UsuarioModel = Backbone.Model.extend({
                urlRoot: app.root + "/usuario",
                defaults: {
                    'nombre': '',
                    'password': '',
                    'isActive': true
                },
                isLoggedIn: function() {
                    return (this.has('username')); 
                },
                // utilizamos un custom url
                getCustomUrl: function (method) {
                    switch (method) {
                        case 'read':
                            return this.urlRoot;
                            break;
                        case 'create':
                            return this.urlRoot;
                            break;
                        case 'update':
                            return this.urlRoot + "/" + this.id;
                            break;
                        case 'delete':
                            return this.urlRoot + "/" + this.id;
                            break;
                    }
                },
                // sincronizamos las opciones de guardado
                sync: function (method, model, options) {
                    options || (options = {});
                    options.url = this.getCustomUrl(method.toLowerCase());

                    // Lets notify backbone to use our URLs and do follow default course
                    return Backbone.sync.apply(this, arguments);
                },
                validation: {
                    nombre: {
                      required: true,
                      msg: 'Por favor ingresa tu nombre'
                    },
                    email: [{
                      required: true,
                      msg: 'Ingresa tu correo'
                    },{
                      pattern: 'email',
                      msg: 'El email proporcionado no es valido'
                    }],
                    password: {
                        minLength: 8
                    },
                    repetir: {
                        equalTo: 'password',
                        msg: 'Las contraseñas deben de coincidir'
                    }
                }
            });
            return UsuarioModel;
        });
