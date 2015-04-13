define([
    'jquery',
    'underscore',
    'Backbone',
    'views/ItemProductoView',
    'text!templates/SectionSecundarioView.tpl',
    'bootstrap',
    'jquery.masonry.min'
],
        function ($, _, Backbone, ItemProductoView, SectionSecundarioViewTemplate) {
            var SectionSecundarioView = Backbone.View.extend({
                tagName: 'section',
                template: _.template(SectionSecundarioViewTemplate),
                initialize: function () {
                    console.log('inicializando sectionsecundarioview');
                    this.id = 'secundario';
                    this.status = '';
                    this.collection.on('add', this.addOne, this);
                    this.collection.on('reset', this.render, this);
                },
                events: {
                    
                },
                render: function () {
                    console.log('render sectionsecundarioview');
                    if(!app.views.productos){
                        app.views.productos = [];
                    }
                    this.$el.html(this.template());
                    this.status = 'render';
                    this.collection.forEach(this.addOne, this);
                    this.status = '';
                    return this;
                },
                addOne: function (model) {
                    console.log(model);
                    console.log('render itemproductoview');
                    var itemProductoView = new ItemProductoView({model: model});
                    itemProductoView.render();
                    this.$el.find('.productos').append(itemProductoView.el);
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
                destroy_view: function () {
                    // COMPLETELY UNBIND THE VIEW 
                    this.undelegateEvents();
                    this.$el.removeData().unbind();
                    // Remove view from DOM 
                    this.remove();
                    Backbone.View.prototype.remove.call(this);
                }
                
            });
            return SectionSecundarioView;
        });