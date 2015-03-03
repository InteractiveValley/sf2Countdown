define([
    'jquery', 
    'underscore',
    'Backbone',
    'collections/CarritoCollection',
    'views/ItemProductoCarritoView',
    'text!templates/CarritoView.tpl'
],
    function ($, _, Backbone, CarritoCollection, ItemProductoCarritoView, CarritoViewTemplate) {
        var CarritoView = Backbone.View.extend({
            el: $('#carrito'),
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
                app.collections.carrito.fetch();
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
                console.log("render carritoview");
                this.status = 'render';
                this.renderCarrito();
                this.collection.forEach(this.addOne,this);
                this.renderTotales();
                this.status = '';
                return this;
            },
            addOne: function(model){
              var itemProductoCarritoView = new ItemProductoCarritoView({model: model});
              if(!app.views.apartados){
                  app.views.apartados = [];
              }
              app.views.apartados.push(itemProductoCarritoView);
              itemProductoCarritoView.render();
              this.$el.find('ul.list-carrito').append(itemProductoCarritoView.el);
              console.log("render itemproductocarrito "+ model.get('slug'));
              if(this.status == ''){
                  this.renderTotales();
              }
            },
            renderTotales: function(){
                console.log("render totalescarrito");
                var carrito = this.collection.getTotalesCarrito();
                this.$el.find(".total").text(carrito.total + " MXN");
                this.$el.find(".descuento-carrito").text(carrito.descuento + " MXN");
            },
            renderCarrito: function(){
                console.log("render carrito");
                var carrito = this.collection.getTotalesCarrito();
                var html = this.template({'carrito': carrito});
                this.$el.html(html);
            }
        });
        return CarritoView;
});