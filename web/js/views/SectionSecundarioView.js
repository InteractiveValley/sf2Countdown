define([
    'jquery',
    'underscore',
    'Backbone',
    'views/ItemProductoView',
    'text!templates/SectionSecundarioView.tpl'
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
                    this.$el.html(this.template());
                    this.status = 'render';
                    this.collection.forEach(this.addOne, this);
                    this.status = '';
                    return this;
                },
                addOne: function (model) {
                    console.log(model);
                    console.log('render itemproductoview')
                    var itemProductoView = new ItemProductoView({model: model});
                    itemProductoView.render();
                    this.$el.find('.productos').append(itemProductoView.el);
                }
            });
            return SectionSecundarioView;
        });