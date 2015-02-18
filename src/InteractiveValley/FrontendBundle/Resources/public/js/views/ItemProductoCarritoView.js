//esta vista es para visualizar el show_template
Countdown.Views.ItemProductoCarritoView = Backbone.View.extend({
    tagName: 'li',
    className: 'item-carrito',
    //template: swig.compile($("#item_producto_carrito_template").html()),
    events: {
        'click a':'seleccionarProyecto'
    },
    initialize: function() {
        this.$el.addClass('active');
        this.template = swig.compile($("#item_carrito_activo_template").html());
        this.templateInactive = swig.compile($("#item_carrito_inactivo_template").html());
    },
    render: function() {
        if(this.model.get('in_carrito')){
            var html = this.template({producto: this.model});
        }else{
            var html = this.templateInactive({producto: this.model});
        }
        this.$el.html(html);
        return this;
    }
});


