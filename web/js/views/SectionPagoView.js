define([
    'jquery', 
    'underscore',
    'Backbone',
    'collections/CarritoCollection',
    'views/ItemProductoPagoView',
    'text!templates/SectionPagoView.tpl',
    'text!templates/PagoEnvioView.tpl',
    'text!templates/PagoFacturacionView.tpl'
],
    function ($, _, Backbone, CarritoCollection, ItemProductoPagoView, SectionPagoViewTemplate, PagoEnvioViewTemplate, PagoFacturacionViewTemplate) {
        var PagoView = Backbone.View.extend({
            tagName: 'section',
            template: _.template( SectionPagoViewTemplate ),
            templatePagoEnvio: _.template( PagoEnvioViewTemplate ),
            templatePagoFacturacion: _.template( PagoFacturacionViewTemplate ),
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
                
                app.envio.on('change',this.renderEnvio(),this);
                app.facturacion.on('change',this.renderFacturacion(),this);
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
                this.renderEnvio();
                this.renderFacturacion();
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
            },
            renderEnvio: function(){
                var html = this.templatePagoEnvio({'envio': app.envio.toJSON()});
                this.$el.find("#tableEnvio").html(html);
            },
            renderFacturacion: function(){
                var html = this.templatePagoFacturacion({'facturacion': app.facturacion.toJSON()});
                this.$el.find("#tableFacturacion").html(html);
            },
            destroy_view: function () {
                // COMPLETELY UNBIND THE VIEW 
                this.undelegateEvents();
                this.$el.removeData().unbind();
                // Remove view from DOM 
                this.remove();
                Backbone.View.prototype.remove.call(this);
            }
        });
        return PagoView;
});