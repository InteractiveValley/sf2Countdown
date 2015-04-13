define([
    'jquery',
    'underscore',
    'Backbone',
    'views/ProductoPromoView',
    'text!templates/SectionPromoView.tpl',
    'bootstrap',
    'jquery.bxslider.min'
],
        function ($, _, Backbone, ProductoPromoView, SectionPromoViewTemplate) {
            var SectionPromoView = Backbone.View.extend({
                tagName: 'section',
                template: _.template( SectionPromoViewTemplate ),
                initialize: function () {
                    console.log('inicializando sectionpromoview');
                    this.id = 'promos';
                    this.status = '';
                    this.collection.on('add', this.addOne, this);
                    this.collection.on('reset', this.render, this);
                },
                events: {
                    
                },
                render: function () {
                    console.log('render sectionpromoview');
                    this.$el.html(this.template());
                    this.status = 'render';
                    this.collection.forEach(this.addOne, this);
                    this.status = '';
                    return this;
                },
                addOne: function (model) {
                    var productoPromoView = new ProductoPromoView({model: model});
                    productoPromoView.render();
                    this.$el.find('.lista-producto-promo').append(productoPromoView.el);
                },
                limpiarProductos: function(){
                    for(var i = app.collections.productos.length -1; i>=0;i--){
                        app.collections.productos.models[i].destroy();
                    }
                },
                masonry: function(){
                    this.$el.find('.productos').masonry({
                        // options
                        itemSelector: '.producto',
                        columnWidth: 247
                    });
                    windows.resize();
                },
                bxSlider: function(){
                    this.$el.find('.lista-producto-promo').bxSlider({
                        auto: true,
                        autoControls: true
                    });
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
            return SectionPromoView;
        });