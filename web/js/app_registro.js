Countdown.Models.Usuario = Backbone.Model.extend({
    defaults: {
      nombre: '',
      email: '',
      password: '',
      repetir: ''
    },
    validarEmail: function(){
        $.ajax({
          url: window.api.url + '/existe/email',
          type: 'POST',
          dateType: 'json',
          data: {'email': this.email},
          success: function(data){
              return data.existe;
          },
        });
    },
    validarContraseña: function(){
        if(this.password.length > 0){
            if(this.password == this.repetir){
                return true;
            }else{
                return false;
            }
        }
    },
});

Countdown.Collections.Usuarios = Backbone.Collection.extend({
    model: Countdown.Models.Usuario,
    
});


//Item de la lista de categorias
Countdown.Views.RegistroView = Backbone.View.extend({
    tagName: 'article',
    className: 'registro-view',
    id: 'registro-view',
    //template: swig.compile($("#item_categoria_template").html()),
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
