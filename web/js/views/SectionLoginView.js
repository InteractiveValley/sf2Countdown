define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/UsuarioModel',
    'text!templates/SectionLoginView.tpl'
],
    function ($, _, Backbone, UsuarioModel, SectionLoginViewTemplate) {
        var SectionLoginView = Backbone.View.extend({
            tagName: 'section',
            template: _.template( SectionLoginViewTemplate ),
            initialize: function() {
                console.log('inicializando sectionprincipalview');
                this.id = 'login';
                this.model = new UsuarioModel();
            },
            events:{
                "submit #formLogin": "login"
            },
            render:function () {
                var data = this.model.toJSON();
                this.$el.html(this.template({usuario: data}));
                return this;
            },
            login: function(e){
                e.preventDefault();
                e.stopPropagation();
                var form = $("#formLogin");
                var self = this;
               $.ajax({
                   url: app.login_check,
                   data: form.serialize(),
                   dataType: 'json',
                   type: 'POST',
                   success: function(data){
                        if(data.success == true){
                            console.log('login');
                            console.log(data);
                            app.user.fetch({success: function(data){
                               app.routers.router.navigate("registro",{trigger: true});
                            }});
                        }else{
                            console.log('Otro mensaje');
                            console.log(data);
                            this.$el.find("#mensajeError").text(data.message);
                            this.$el.find("#mensajeError").fadeIn('fast',function(){
                               setTimeout(function(){
                                   self.$el.find("#mensajeError").fadeOut('fast');
                               },2000); 
                            });
                        }
                   },
                   error: function(data){
                       console.log(data);
                       alert("Error");
                   }
               });
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
        return SectionLoginView;
});