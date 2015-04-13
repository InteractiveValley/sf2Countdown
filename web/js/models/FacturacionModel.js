define([
    'underscore',
    'backbone.validation'
],
        function (_, Backbone) {
            var FacturacionModel = Backbone.Model.extend({
                urlRoot: app.root + "/facturacion",
                defaults: {
                    'isFacturar': false,
                    'rfc': '',
                    'razonSocial':'',
                    'calle': '',
                    'numExterior': '',
                    'numInterior': '',
                    'cp': '',
                    'municipio': '',
                    'colonia': '',
                    'ciudad': '',
                    'estado': '',
                    'emailEnvio':'',
                    'contacto': '',
                    'telefonoContacto':''
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
                    rfc: {
                      required: false,
                      msg: 'Favor de ingresar el nombre de la calle'
                    },
                    razonSocial: {
                      required: false,
                      msg: 'Favor de ingresar el nombre de la calle'
                    },
                    calle: {
                      required: false,
                      msg: 'Favor de ingresar el nombre de la calle'
                    },
                    colonia: {
                      required: false,
                      msg: 'Favor de ingresar el nombre de la colonia'
                    },
                    cp: {
                      required: false,
                      msg: 'Favor de ingresar el codigo postal'
                    },
                    emailEnvio: [{
                      required: false,
                      msg: 'Ingresa el correo'
                    },{
                      pattern: 'email',
                      msg: 'El email proporcionado no es valido'
                    }],
                    contacto: {
                      required: false,
                      msg: 'Favor de ingresar el nombre del contacto'
                    },
                    telefonoContacto: {
                      required: false,
                      msg: 'Favor de ingresar el telefono del contacto'
                    },
                }
            });
            return FacturacionModel;
        });
