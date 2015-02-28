define([
    'jquery', 
    'underscore',
    'swig',
    'Backbone',
    'models/ProductoModel',
    'text!templates/ModalProductoView.tpl'
],
    function ($, _, swig, Backbone, ProductoModel, ModalProductoViewTemplate) {
        var ModalProductoView = Backbone.View.extend({
            el: "#modalProducto",
			tagName: 'div',
			className: 'modal fade',
            template: _.template( ModalProductoViewTemplate ),
            initialize: function() {
				console.log('inicializando modalproductoview');
                this.id = 'modalProducto';
				this.status = '';
			},
            events:{
            
			},
            render: function(){
			  if(this.model != null ){
				  var data = this.model.toJSON();
				  var html = this.template({'producto': data});
				  this.$el.html(html);
			  }
			  return this;
            }
        });
        return ModalProductoView;
});