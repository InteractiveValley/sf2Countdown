define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/UsuarioModel',
    'models/EnvioModel',
    'models/FacturacionModel',
    'text!templates/SectionRegistroView.tpl'
],
    function ($, _, Backbone, UsuarioModel, EnvioModel, FacturacionModel, SectionRegistroViewTemplate) {
        var SectionRegistroView = Backbone.View.extend({
            tagName: 'section',
            className: 'container',
            template: _.template( SectionRegistroViewTemplate ),
            initialize: function() {
                console.log('inicializando sectionregistroview');
                this.id = 'registro';
                if(!app.views.appView.usuario){
                    app.views.appView.usuario = new UsuarioModel({id: 0});
                }
                this.model = app.user;
                this.envio = new EnvioModel({'usuario': this.model.get('id')});
                this.envio.fetch();
                this.facturacion = new FacturacionModel({'usuario': this.model.get('id')});
                this.facturacion.fetch();
                this.model.on('change',this.render,this);
                this.envio.on('change',this.render,this);
                this.facturacion.on('change',this.render,this);
            },
            events:{
                "change"        : "change"
            },
            render: function(){
                var usuarioData     = this.model.toJSON();
                var envioData       = this.envio.toJSON();
                var facturacionData = this.facturacion.toJSON();
                this.$el.html(this.template({usuario: usuarioData, envio: envioData, factuacion: facturacionData}));
                return this;
            },
            change: function (event) {
                debugger;
                // Apply the change to the model
                var target = event.target;
                var change = {};
                
                change[target.name] = target.value;
                this.model.set(change);

                // Run validation rule (if any) on changed item
                var check = this.model.validateItem(target.id);
                if (check.isValid === false) {
                    utils.addValidationError(target.id, check.message);
                } else {
                    utils.removeValidationError(target.id);
                }
            }
        });
        return SectionRegistroView;
});