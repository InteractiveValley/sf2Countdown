define([
    // Libraries
    'jquery', 
    'underscore',
    'swig',
    'Backbone',
    // colleciones
    'collections/ProductosCollection',
    // vistas
    'views/CarritoView',
    'views/ModalProductoView',
    'views/SectionPrincipalView',
    'views/SectionSecundarioView'
],

function($, _, swig, Backbone, ProductosCollection, CarritoView, ModalProductoView, SectionPrincipalView, SectionSecundarioView) {

  var AppRouter = Backbone.Router.extend({

    routes: {
        "":                         "inicio",
        "categoria/:slug":          "categoria",
		"producto/carrito/:slug":   "showProductoCarrito",
        "producto/:slug":           "showProducto"
    },

    initialize: function () {
        if(!app.views.carrito){
            app.views.carrito = new CarritoView();
            app.views.carrito.render();
        }
        //app.views.appView.$el.find('#carrito').html(app.views.carrito.$el.html());
    },
    inicio: function () {
        app.status = 'principal';
        //renderiza una sola vez
        if(!app.views.principal){
            app.views.principal = new SectionPrincipalView();
            app.views.principal.render();
        }
        app.views.appView.$el.find('#division-principal').html(app.views.principal.el);
        //this.pageslider.slidePage(app.views.principal.el);
    },
    categoria: function(slug){
        //renderiza una sola vez
	if (!app.collections.productos) {
            app.collections.productos = new ProductosCollection();
        }
        //renderiza una sola vez
        if(!app.views.secundario){
            app.views.secundario = new SectionSecundarioView({collection: app.collections.productos});
            app.views.secundario.render();
        }
        if(app.status != 'secundario'){
            app.status = 'secundario';
            app.views.appView.$el.find('#division-principal').html(app.views.secundario.el);
        }
        
        app.views.secundario.limpiarProductos();
        app.views.secundario.$el.find('section.productos').addClass('cargando');
        
	var xhr = app.collections.productos.fetch({data: {'categoria': slug}});
        xhr.done(function(data){
			console.log(data);
            app.views.secundario.$el.find('section.productos').removeClass('cargando');
        }).fail(function(data){
            console.log(data);
            console.log("Se no se obtuvieron datos");
        });
        //app.collections.productos.fetch();
	
    },
    showProducto: function(slug){
        debugger;
        var models = app.collections.productos.where({'slug': slug});
        if(!app.views.producto){
            app.views.producto = new ModalProductoView({model: models[0]});
            app.views.producto.render();
        }else{
            app.views.producto.cambiarModel(models[0]);
            app.views.producto.render();
        }
        //app.views.appView.$el.append(app.views.producto.$el.html());
        app.views.producto.showModal();
    },
    employeeDetails: function (id) {
        var employee = new Employee({id: id});
        employee.fetch({
            success: function (data) {
                // Note that we could also 'recycle' the same instance of EmployeeFullView
                // instead of creating new instances
                slider.slidePage(new EmployeeView({model: data}).render().$el);
            }
        });
    }

  });

  return AppRouter;
});