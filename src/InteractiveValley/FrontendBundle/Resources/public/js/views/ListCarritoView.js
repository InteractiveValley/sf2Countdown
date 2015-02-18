//vista collecio que recibe todos los modelos.
Countdown.Views.ListCarritoView = Backbone.View.extend({
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

