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
            initialize: function() {
		console.log('inicializando carritoview');
                this.status = '';
                if(!app.collections.carrito){
                    app.collections.carrito = new CarritoCollection();
                }
                this.collection = app.collections.carrito;
                this.collection.on('add', this.addOne, this);
                this.collection.on('remove', this.renderTotales, this);
                this.collection.on('reset', this.render, this);
                app.collections.carrito.fetch();
            },
            events:{
               'click #hacerPedido': 'hacerPedido',
               'mouseleave  ':    'hideCarrito'
            },
            hideCarrito: function(){
                app.views.appView.$el.find("#showCarrito").click();
            },
            hacerPedido: function(e){
                e.preventDefault();
                e.stopPropagation();
                if(app.user.isLoggedIn()){
                    app.routers.router.navigate('pago',{trigger: true});
                }else{
                    app.routers.router.navigate('login',{trigger: true});
                }
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
              debugger;
              var itemProductoCarritoView = new ItemProductoCarritoView({model: model});
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