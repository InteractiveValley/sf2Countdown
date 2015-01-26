window.Countdown = {};

Countdown.Views = {};
Countdown.Collections = {};
Countdown.Models = {};
Countdown.Routers = {};

window.routers = {};
window.models = {};
window.views = {};
window.collections = {};


Countdown.Models.Categoria = Backbone.Model.extend({
    defaults: {
      nombre: '',
      slug: '',
      position: 0,
      is_active: true,
      activa: false,
    }
});

Countdown.Collections.Categorias = Backbone.Collection.extend({
    model: Countdown.Models.Categoria,
    desactivarTodas: function(){
       _.each(this.collection, function(model){ 
          if(model.get('activa')==true){
              model.set('activa',false);
          }
      });
    }
});


//Item de la lista de categorias
Countdown.Views.ItemCategoriaView = Backbone.View.extend({
    tagName: 'li',
    className: 'item-categoria',
    template: swig.compile($("#item_categoria_template").html()),
    events: {
        "click .item-categoria": "seleccionada"
    },
    initialize: function() {
        this.model.on("change",this.render,this);
    },
    render: function() {
        var data = this.model.toJSON();
        var html = this.template(data);
        this.$el.html(html);
        return this;
    },
    seleccionada: function(){
        collections.categorias.desactivarTodas();
        this.model.set('activa',true);
    }
});


//Lista de categorias
Countdown.Views.ListCategoriasView = Backbone.View.extend({
    el: 'ul.list-categorias',
    tagName: 'ul',
    //template: swig.compile($("#app_template").html()),
    events: {

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

Countdown.Routers.App = Backbone.Router.extend({
    routes: {
        "" : "root",
        "categorias": 'root'
    },
    root: function() {
        /*window.views.listCategoriasView = new Countdown.Views.ListCategoriasView({
            collection: window.collections.categorias,
        });
        views.listCategoriasView.render();*/
    }
});


function formato_numero(numero, decimales, separador_decimal, separador_miles){ 
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}