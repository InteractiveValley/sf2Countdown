define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/UsuarioModel',
    'text!templates/SectionRegistroView.tpl'
],
    function ($, _, Backbone, UsuarioModel, SectionRegistroViewTemplate) {
        var SectionRegistroView = Backbone.View.extend({
            tagName: 'section',
            className: 'container',
            template: _.template( SectionRegistroViewTemplate ),
            initialize: function() {
                console.log('inicializando sectionregistroview');
                this.id = 'registro';
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
        return SectionRegistroView;
});