define([
    'jquery', 
    'underscore',
    'backbone.validation',
    'text!templates/SectionFacturacionView.tpl'
],
    function ($, _, Backbone,  SectionFacturacionViewTemplate ) {
        var SectionFacturacionView = Backbone.View.extend({
            tagName: 'section',
            className: 'container',
            templateFacturacion:          _.template( SectionFacturacionViewTemplate ),
            initialize: function() {
                console.log('inicializando sectionfacturacionview');
                this.id = 'facturacion';
                this.model = app.facturacion;
                var self = this;
                if(app.facturacion.isNew()){
                    this.model.fetch({success: function(data){
                        self.renderFacturacion();
                    }});
                }
                //this.validarFacturacion();
                Backbone.Validation.bind(this);
                this.statusGuardar = false;
            },
            events:{
                "change #facturacion_isFacturar": "changeIsFacturar",
                "change"                : "change",
                "click #btnGuardar"     : "guardarFacturacion",
                "click #btnSiguiente"   : "siguiente"
            },
            render: function(){
                this.renderFacturacion();
                return this;
            },
            siguiente: function(e){
                e.preventDefault();
                debugger;
                if(this.statusGuardar){
                    this.guardar('pago');
                }else if(app.user.isLoggedIn()){
                    app.routers.router.navigate('pago',{trigger: true});
                }else{
                    return this.model.isValid(true);
                }
            },
            guardarFacturacion: function(e){
                e.preventDefault();
                debugger;
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
                                app.facturacion.set(model);
                                app.facturacion.fetch({success: function(data){
                                    if(!app.user.isLoggedIn()){
                                        app.routers.router.navigate('login',{trigger: true});
                                    }else{
                                        app.routers.router.navigate('pago',{trigger: true});
                                    }
                                }});
                            }else{
                                if(irA == "pago"){
                                    app.routers.router.navigate('pago',{trigger: true});
                                }else{
                                    app.views.appView.$el.find('#division-principal').html(app.views.facturacion.el);
                                    self.renderFacturacion();
                                }
                            }
                        },
                        error: function (model, xhr, options) {
                            alert("Hay un error al grabar el registro");
                            app.views.appView.$el.find('#division-principal').html(app.views.facturacion.el);
                            self.renderFacturacion();
                        }
                    });
                }else{
                    alert('Favor de revisar los datos del formulario');
                    app.views.appView.$el.find('#division-principal').html(app.views.facturacion.el);
                    self.renderFacturacion();
                }
            },
            renderFacturacion: function(){
                var facturacionData     = this.model.toJSON();
                app.views.appView.$el.find('#division-principal').removeClass('cargando');
                this.$el.html(this.templateFacturacion({facturacion: facturacionData}));
                return this;
            },
            changeIsFacturar: function (event) {
                debugger;
                event.preventDefault();
                event.stopPropagation();
                var target = event.target;
                var change = {};
                var arreglo = target.name.split("_");
                change[arreglo[1]] = target.checked;
                this.model.set(change);
                if(this.model.isValid(arreglo[1])){
                    this.valid(arreglo[0],arreglo[1]);
                }else{
                    var errorMessage = this.model.preValidate(arreglo[1], target.value);
                    this.invalid(arreglo[0],arreglo[1], errorMessage);
                }
                this.statusGuardar = true;
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
        return SectionFacturacionView;
});