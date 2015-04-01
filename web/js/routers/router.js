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
    'views/ModalProductoCarritoView',
    'views/SectionPrincipalView',
    'views/SectionSecundarioView',
    'views/SectionPagoView',
    'views/SectionLoginView',
    'views/'
],

function($, _, swig, Backbone, ProductosCollection, CarritoView, ModalProductoView, ModalProductoCarritoView, SectionPrincipalView, SectionSecundarioView, SectionPagoView, SectionLoginView) {

  var AppRouter = Backbone.Router.extend({

    routes: {
        "":                         "inicio",
        "categoria/:slug":          "categoria",
	"producto/carrito/:id":     "showProductoCarrito",
        "producto/:slug":           "showProducto",
        "pago":                     "pago",
        "login":                    "login"
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
        app.views.appView.$el.find('#division-principal').html(app.views.principal.el).fadeIn('fast');
        $(".item-navbar-colores").fadeOut("fast");
        $(".item-navbar-precio").fadeOut("fast");
        
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
            $(".item-navbar-colores").fadeIn("fast");
            $(".item-navbar-precio").fadeIn("fast");
            app.views.appView.$el.find('#division-principal').html(app.views.secundario.el).fadeIn('fast');
        }
        app.status = 'secundario';
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
        var models = app.collections.productos.where({'slug': slug});
        if(!app.views.producto){
            app.views.producto = new ModalProductoView({model: models[0]});
            app.views.producto.render();
        }else{
            app.views.producto.destroy_view();
            app.views.producto = new ModalProductoView({model: models[0]});
            app.views.producto.render();
        }
        app.views.appView.$el.append(app.views.producto.el);
        app.views.producto.showModal();
    },
    showProductoCarrito: function(id){
        debugger;
        var models = app.collections.carrito.where({'productoId': id});
        if(!app.views.productoCarrito){
            app.views.productoCarrito = new ModalProductoCarritoView({model: models[0]});
            app.views.productoCarrito.render();
        }else{
            app.views.productoCarrito.destroy_view();
            app.views.productoCarrito = new ModalProductoCarritoView({model: models[0]});
            app.views.productoCarrito.render();
        }
        app.views.appView.$el.append(app.views.productoCarrito.el);
        app.views.productoCarrito.showModal();
    },
    pago: function(){
        debugger;
        if(app.status != 'pago'){
            app.status = 'pago';
            $(".item-navbar-colores").fadeOut("fast");
            $(".item-navbar-precio").fadeOut("fast");
        }
        app.status = 'pago';
        //renderiza una sola vez
        if(!app.views.pago){
            app.views.pago = new SectionPagoView({collection: app.collections.carrito});
            app.views.pago.render();
        }
        
        app.views.appView.$el.find('#division-principal').html(app.views.pago.el).fadeIn('fast');
        //this.pageslider.slidePage(app.views.principal.el);
    },
    login: function(){
        debugger;
        if(app.status != 'login'){
            app.status = 'login';
            $(".item-navbar-colores").fadeOut("fast");
            $(".item-navbar-precio").fadeOut("fast");
        }
        app.status = 'login';
        //renderiza una sola vez
        if(!app.views.login){
            app.views.login = new SectionLoginView();
            app.views.login.render();
        }
        
        app.views.appView.$el.find('#division-principal').html(app.views.login.el).fadeIn('fast');
        //this.pageslider.slidePage(app.views.principal.el);
    },
    registro: function(){
        debugger;
        if(app.status != 'registro'){
            app.status = 'registro';
            $(".item-navbar-colores").fadeOut("fast");
            $(".item-navbar-precio").fadeOut("fast");
        }
        app.status = 'registro';
        //renderiza una sola vez
        if(!app.views.registro){
            app.views.registro = new SectionLoginView();
            app.views.registro.render();
        }
        
        app.views.appView.$el.find('#division-principal').html(app.views.login.el).fadeIn('fast');
        //this.pageslider.slidePage(app.views.principal.el);
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