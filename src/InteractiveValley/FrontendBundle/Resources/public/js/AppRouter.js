//router de la app
Countdown.Routers.AppRouter = Backbone.Router.extend({
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