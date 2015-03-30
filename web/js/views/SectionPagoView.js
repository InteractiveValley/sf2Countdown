define([
    'jquery', 
    'underscore',
    'Backbone',
    'collections/CarritoCollection',
    'views/ItemProductoPagoView',
    'text!templates/SectionPagoView.tpl'
],
    function ($, _, Backbone, CarritoCollection, ItemProductoPagoView, SectionPagoViewTemplate) {
        var PagoView = Backbone.View.extend({
            tagName: 'section',
            template: _.template( SectionPagoViewTemplate ),
            initialize: function() {
		console.log('inicializando sectionpagoview');
                this.status = '';
                if(!app.collections.carrito){
                    app.collections.carrito = new CarritoCollection();
                    this.collection = app.collections.carrito;
                    app.collections.carrito.fetch();
                }
                this.collection.on('add', this.addOne, this);
                this.collection.on('remove', this.renderTotales, this);
                this.collection.on('reset', this.render, this);
            },
            events:{
               'click #hacerPago': 'hacerPago'
            },
            hacerPago: function(e){
                e.preventDefault();
                e.stopPropagation();
                app.routers.router.navigate('pago',{trigger: true});
            },
            render:function () {
                console.log("render sectionpagoview");
                this.status = 'render';
                this.renderCarrito();
                this.collection.forEach(this.addOne,this);
                this.renderTotales();
                this.status = '';
                return this;
            },
            addOne: function(model){
              debugger;
              var itemProductoPagoView = new ItemProductoPagoView({model: model});
              itemProductoPagoView.render();
              this.$el.find('table.productos-pago').append(itemProductoPagoView.el);
              console.log("render itemproductopago "+ model.get('slug'));
              if(this.status == ''){
                  this.renderTotales();
              }
            },
            renderTotales: function(){
                console.log("render totalescarrito");
                var carrito = this.collection.getTotalesCarrito();
                this.$el.find(".total-importe").text(carrito.total + " MXN");
                this.$el.find(".total-descuento").text(carrito.descuento + " MXN");
            },
            renderCarrito: function(){
                console.log("render carrito");
                var carrito = this.collection.getTotalesCarrito();
                var html = this.template({'carrito': carrito});
                this.$el.html(html);
            }
        });
        return PagoView;
});