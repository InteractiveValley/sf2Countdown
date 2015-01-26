Countdown.Models.Producto = Backbone.Model.extend({
    defaults: {
      nombre: '',
      slug: '',
      inventario: 0,
      reservado: 0, 
    },
    getPrecioFormat: function(){
        return formato_numero(precio, 2, ".", ",");
    },
    getTiempoFormat: function(){
        return "20 min 5 seg";
    }
});

Countdown.Collections.Productos = Backbone.Collection.extend({
    model: Countdown.Models.Producto
});

//esta vista es para visualizar el show_template
Countdown.Views.ItemProductoCarritoView = Backbone.View.extend({
    tagName: 'li',
    className: 'item-carrito',
    template: swig.compile($("#item_producto_carrito_template").html()),
    events: {
        'click a':'seleccionarProyecto'
    },
    initialize: function() {
        
    },
    render: function() {
        var html = this.template({producto: this.model});
        this.$el.html(html);
        return this;
    }
});


//vista collecio que recibe todos los modelos.
Countdown.Views.DivCarritoView = Backbone.View.extend({
    el: '.carrito',
    tagName: 'div',
    //template: swig.compile($("#app_template").html()),
    events: {
        "click .item-categoria": "categoriaSeleccionada"
    },
    AddOne: function(categoria) {
        debugger;
        var itemCategoriaView = new Countdown.Views.ItemCategoriaView({model: categoria});
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

