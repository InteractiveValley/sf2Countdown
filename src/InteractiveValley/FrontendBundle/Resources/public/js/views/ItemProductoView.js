//Item de la lista de productos
Countdown.Views.ItemProductoView = Backbone.View.extend({
    tagName: 'article',
    className: 'producto',
    template: swig.compile($("#item_producto_template").html()),
    events: {
        'click .agregar-carrito': 'agregarCarrito',
        'click .ver-producto': 'verProducto'
    },
    initialize: function() {
        this.model.on('change',this.render,this);
        if(this.model.get('isPromocional')){
            this.$el.addClass('imagen_grande');
        }else{
            this.$el.addClass('imagen_chica');
        }
    },
    render: function() {
        if(!this.model.get('in_carrito')){
            var html = this.template({producto: this.model.toJSON()});
            this.$el.html(html);
        }else{
            this.$el.remove();
        }
        return this;
    },
    agregarCarrito: function(e){
        e.preventDefault();
        Countdown.collections.carrito.add(this.model);
        this.model.set('in_carrito',true);
    },
    verProducto: function(e){
        e.preventDefault();
        
    }
});

