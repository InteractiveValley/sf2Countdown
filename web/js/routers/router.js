define([
    // Libraries
    'jquery', 
    'underscore',
    'swig',
    'Backbone',
    // vistas
    'views/CarritoView',
    'views/ModalProductoView',
    'views/SectionPrincipalView',
    'views/SectionSecundarioView'
],

function($, _, swig, Backbone, CarritoView, ModalProductoView, SectionPrincipalView, SectionSecundarioView) {

  var AppRouter = Backbone.Router.extend({

    routes: {
        "":                         "inicio",
        "categoria/:slug":          "categoria"
    },

    initialize: function () {
        if(!app.views.carrito){
            app.views.carrito = new CarritoView();
            app.views.carrito.render();
        }
        app.views.appView.$el.find('#carrito').html(app.views.carrito.$el.html());
        
        if(!app.views.producto){
            app.views.producto = new ModalProductoView({model: null});
            app.views.producto.render();
        }
        app.views.appView.$el.append(app.views.producto.el);
    },
    inicio: function () {
        app.status = 'principal';
        //renderiza una sola vez
        if(!app.views.principal){
            app.views.principal = new SectionPrincipalView();
            app.views.principal.render();
        }
        app.views.appView.$el.find('#division-principal').html(app.views.principal.el);
    },
    categoria: function(slug){
        //renderiza una sola vez
        if(!app.views.secundario){
            app.views.secundario = new SectionSecundarioView();
            app.views.secundario.render();
        }
        if(app.status != 'secundario'){
            app.status = 'secundario';
            app.views.appView.$el.find('#division-principal').html(app.views.secundario.el);
        }
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