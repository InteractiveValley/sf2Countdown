define([
    'underscore',
    'backbone.validation'
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
                    'estado': '',
                    'telefono': '',
                    'observaciones': ''
                },
                isNew: function() {
                    return !(this.has('id')); 
                },
                // Lets create function which will return the custom URL based on the method type
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
                // Now lets override the sync function to use our custom URLs
                sync: function (method, model, options) {
                    options || (options = {});
                    options.url = this.getCustomUrl(method.toLowerCase());

                    // Lets notify backbone to use our URLs and do follow default course
                    return Backbone.sync.apply(this, arguments);
                },
                validation: {
                    calle: {
                      required: true,
                      msg: 'Favor de ingresar el nombre de la calle'
                    },
                    colonia: {
                      required: true,
                      msg: 'Favor de ingresar el nombre de la colonia'
                    },
                    cp: {
                      required: true,
                      msg: 'Favor de ingresar el codigo postal'
                    }
                }
            });
            return EnvioModel;
        });
