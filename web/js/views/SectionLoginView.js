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
            
            },
            render:function () {
                var data = this.model.toJSON();
                this.$el.html(this.template({usuario: data}));
                return this;
            }
        });
        return SectionLoginView;
});