define([
    'jquery', 
    'underscore',
    'swig',
    'Backbone',
    'collections/ProductosCollection',
    'views/ItemProductoView',
    'text!templates/SectionSecundarioView.tpl'
],
    function ($, _, swig, Backbone, ProductosCollection, ItemProductoView, SectionSecundarioViewTemplate) {
        var SectionSecundarioView = Backbone.View.extend({
            tagName: 'section',
            template: _.template( SectionSecundarioViewTemplate ),
            initialize: function() {
				console.log('inicializando sectionsecundarioview');
                this.id = 'secundario';
				this.status = '';
                if(!app.collections.productos){
                    app.collections.productos = new ProductosCollection();
                }
                this.collection = app.collections.productos;
                this.collection.on('add', this.addOne, this);
                this.collection.on('reset', this.render, this);
			},
            events:{
            
			},
			render:function () {
                this.status = 'render';
                this.collection.forEach(this.addOne,this);
                this.status = '';
                return this;
            },
            addOne: function(model){
              var itemProductoView = new ItemProductoView({model: model});
              itemProductoView.render();
              this.$el.find('.list-carrito').append(itemProductoView.el);
              if(this.status == ''){
                  this.renderTotales();
              }
            }
        });
        return SectionSecundarioView;
});