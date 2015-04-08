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
               $.ajax({
                   url: app.login_check,
                   data: form.serialize(),
                   dataType: 'json',
                   type: 'POST',
                   success: function(data){
                        if(data.success == true){
                            app.views.appView.usuario.set(data.usuario);
                            app.routers.router.navigate("registro",{trigger: true});
                        }else{
                            $("#mensajeError").text(data.message);
                            $("#mensajeError").fadeIn('fast',function(){
                               setTimeout(function(){
                                   $("#mensajeError").fadeOut('fast');
                               },2000); 
                            });
                        }
                   },
                   error: function(data){
                       console.log(data);
                       alert("Error");
                   }
               });
            }
        });
        return SectionLoginView;
});