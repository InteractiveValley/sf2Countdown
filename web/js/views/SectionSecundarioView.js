define([
    'jquery',
    'underscore',
    'Backbone',
    'views/ItemProductoView',
    'text!templates/SectionSecundarioView.tpl',
    'bootstrap',
    'bootstrap-slider',
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
                    this.sliderPrecio();
                    this.status = '';
                    return this;
                },
                addOne: function (model) {
                    console.log(model);
                    console.log('render itemproductoview');
                    var itemProductoView = new ItemProductoView({model: model});
                    app.views.productos.push(itemProductoView);
                    itemProductoView.render();
                    this.$el.find('.productos').append(itemProductoView.el);
                },
                limpiarProductos: function(){
                    
                },
                sliderPrecio: function(){
                    /*var self = this;
                    this.$el.find("#sliderPrecio").slider({'tooltip': 'show'}).on('slide', function (ev) {
                        $(self.el).find("#valor-precio").text( formatNumber.new(ev.value,"$"));
                    }).on("slideStop", function (ev) {

                    });*/
                },
                masonry: function(){
                    this.$el.find('.productos').masonry({
                        // options
                        itemSelector: '.producto',
                        columnWidth: 247
                    });
                }
                
            });
            return SectionSecundarioView;
        });