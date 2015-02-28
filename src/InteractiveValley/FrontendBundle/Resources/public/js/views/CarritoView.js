//vista collecio que recibe todos los modelos.
Countdown.Views.CarritoView = Backbone.View.extend({
    el: '#carrito',
    tagName: 'div',
    template: swig.compile($("#carrito_template").html()),
    events: {
        "click .item-categoria": "categoriaSeleccionada"
    },
    AddOne: function(producto) {
        debugger;
        var itemProductoCarritoView = new Countdown.Views.ItemProductoCarritoView({model: producto});
        var html = itemCategoriaView.render().el;
        this.$el.append(html); 
    },
    render: function() {
        this.renderAll();
        return this;
    },
    renderAll: function(){
        this.collection.forEach(this.AddOne,this);
        return this;
    }
    
});

