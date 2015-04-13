define([
    'jquery', 
    'underscore',
    'backbone.validation',
    'text!templates/SectionEnvioView.tpl'
],
    function ($, _, Backbone,  SectionEnvioViewTemplate ) {
        var SectionEnvioView = Backbone.View.extend({
            tagName: 'section',
            className: 'container',
            templateEnvio:          _.template( SectionEnvioViewTemplate ),
            initialize: function() {
                debugger;
                console.log('inicializando sectionenvioview');
                this.id = 'envio';
                this.model = app.envio;
                var self = this;
                if(app.envio.isNew()){
                    this.model.fetch({success: function(data){
                        self.renderEnvio();
                    }});
                }
                Backbone.Validation.bind(this);
                this.statusGuardar = false;
            },
            events:{
                "change"                : "change",
                "click #btnGuardar"     : "guardarEnvio",
                "click #btnSiguiente"   : "siguiente"
            },
            render: function(){
                this.renderEnvio();
                return this;
            },
            siguiente: function(e){
                e.preventDefault();
                if(this.statusGuardar){
                    this.guardar('envio');
                }else if(app.user.isLoggedIn()){
                    app.routers.router.navigate('facturacion',{trigger: true});
                }else{
                    return this.model.isValid(true);
                }
            },
            guardarEnvio: function(e){
                e.preventDefault();
                if(this.statusGuardar){
                    this.guardar();
                }else{
                    alert("No hay cambios que guardar");
                }
            },
            guardar:function(irA){
                var self = this;
                var isNew = this.model.isNew();
                irA = irA || "";
                app.views.appView.$el.find('#division-principal').html("").addClass('cargando');
                if(this.model.isValid(true)){
                    this.model.save({}, {
                        success: function (model, response, options) {
                            console.log("The model has been saved to the server");
                            if(isNew){
                                debugger;
                                app.envio.set(model);
                                app.envio.fetch({success: function(data){
                                  app.routers.router.navigate('facturacion',{trigger: true});
                                }});
                            }else{
                                if(irA == "facturacion"){
                                    app.routers.router.navigate('facturacion',{trigger: true});
                                }else{
                                    app.views.appView.$el.find('#division-principal').html(app.views.envio.el);
                                    self.renderEnvio();
                                }
                            }
                        },
                        error: function (model, xhr, options) {
                            alert("Hay un error al grabar el registro");
                            app.views.appView.$el.find('#division-principal').html(app.views.envio.el);
                            self.renderEnvio();
                        }
                    });
                }else{
                    alert('Favor de revisar los datos del formulario');
                    app.views.appView.$el.find('#division-principal').html(app.views.envio.el);
                    self.renderEnvio();
                }
            },
            renderEnvio: function(){
                var envioData     = this.model.toJSON();
                app.views.appView.$el.find('#division-principal').removeClass('cargando');
                this.$el.html(this.templateEnvio({envio: envioData}));
                return this;
            },
            change: function (event) {
                debugger;
                // Apply the change to the model
                var target = event.target;
                var change = {};
                var arreglo = target.name.split("_");
                change[arreglo[1]] = target.value;
                this.model.set(change);
                if(this.model.isValid(arreglo[1])){
                    this.valid(arreglo[0],arreglo[1]);
                }else{
                    var errorMessage = this.model.preValidate(arreglo[1], target.value);
                    this.invalid(arreglo[0],arreglo[1], errorMessage);
                }
                this.statusGuardar = true;
            },
            valid: function(modelo, attr) {
                debugger;
                var $el = this.$el.find('[name=' + modelo+"_"+attr + ']'), 
                    $group = $el.closest('.form-group');

                $group.removeClass('has-error');
                $group.find('.help-block').html('').addClass('hidden');
            },
            invalid: function(modelo, attr, error) {
                debugger;
                var $el = this.$el.find('[name=' + modelo+"_"+attr + ']'), 
                    $group = $el.closest('.form-group');

                $group.addClass('has-error');
                $group.find('.help-block').html(error).removeClass('hidden');
            },
            destroy_view: function () {
                // COMPLETELY UNBIND THE VIEW 
                this.undelegateEvents();
                this.$el.removeData().unbind();
                // Remove view from DOM 
                this.remove();
                Backbone.View.prototype.remove.call(this);
            }
        });
        return SectionEnvioView;
});