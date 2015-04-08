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
                this.model = app.views.appView.usuario;
                this.envio = new EnvioModel({'usuario': this.model.get('id')});
                this.facturacion = new FacturacionModel({'usuario': this.model.get('id')});
                this.model.on('change',this.render,this);
                this.envio.on('change',this.render,this);
                this.facturacion.on('change',this.render,this);
            },
            events:{
                
            },
            render: function(){
                var usuarioData     = this.model.toJSON();
                var envioData       = this.envio.toJSON();
                var facturacionData = this.facturacion.toJSON();
                this.$el.html(this.template({usuario: usuarioData, envio: envioData, factuacion: facturacionData}));
                return this;
            }
        });
        return SectionRegistroView;
});