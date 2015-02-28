define([
    'jquery', 
    'underscore',
    'swig',
    'Backbone',
    'collections/CarritoCollection',
    'views/ItemProductoCarritoView',
    'text!templates/CarritoView.tpl'
],
    function ($, _, swig, Backbone, CarritoCollection, ItemProductoCarritoView, CarritoViewTemplate) {
        var CarritoView = Backbone.View.extend({
            id: 'carrito',
            className: 'flotar',
            tagName: 'div',
            template: _.template( CarritoViewTemplate ),
            //template: swig.compile( CarritoViewTemplate ),
            initialize: function() {
				console.log('inicializando carritoview');
                this.status = '';
                if(!app.collections.carrito){
                    app.collections.carrito = new CarritoCollection();
                }
                this.collection = app.collections.carrito;
                this.collection.on('add', this.addOne, this);
                this.collection.on('reset', this.render, this);
            },
            events:{
               'click #hacerPedido': 'hacerPedido'
            },
            hacerPedido: function(e){
                e.preventDefault();
                e.stopPropagation();
                app.routers.router.navigate('pago',{trigger: true});
            },
            render:function () {
                this.status = 'render';
                this.collection.forEach(this.addOne,this);
                this.renderTotales();
                this.status = '';
                return this;
            },
            addOne: function(model){
              var itemProductoCarritoView = new ItemProductoCarritoView({model: model});
              itemProductoCarritoView.render();
              this.$el.find('.list-carrito').append(itemProductoCarritoView.el);
              if(this.status == ''){
                  this.renderTotales();
              }
            },
            renderTotales: function(){
                var carrito = this.collection.getTotalesCarrito();
                var html = this.template({'carrito': carrito});
                this.$el.html(html);
            }
        });
        return CarritoView;
});