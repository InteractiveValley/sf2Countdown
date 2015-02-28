define([
    'jquery', 
    'underscore',
    'Backbone',
    'text!templates/SectionPrincipalView.tpl'
],
    function ($, _, Backbone,SectionPrincipalViewTemplate) {
        var SectionPrincipalView = Backbone.View.extend({
            tagName: 'section',
            template: _.template( SectionPrincipalViewTemplate ),
            initialize: function() {
				console.log('inicializando sectionprincipalview');
                this.id = 'principal';
			},
            events:{
            
			},
            render:function () {
				this.$el.html(this.template());
                return this;
            }
        });
        return SectionPrincipalView;
});