require.config({
    paths:{
        // RequireJS plugin
        text:'libs/require/text',
        // RequireJS plugin
        domReady:'libs/require/domReady',
        // underscore library
        underscore:'libs/underscore-min',
        // swig library
        swig:'libs/swig',
        // Backbone.js library
        Backbone:'libs/backbone-min',
        // jQuery
        jquery:'jquery',
        //router
        router: 'routers/router'
    },
    shim:{
        Backbone:{
            deps:['underscore', 'jquery'],
            exports:'Backbone'
        },
        underscore:{
            exports:'_'
        }
    }
});

var app = {
    views: {},
    models: {},
    collections: {},
    routers: {},
    root: 'http://localhost:8040/app_dev.php/api',
    status: '',
    showCarrito: false,
    categoria: 'lo-nuevo',
    user: {},
    ls: {}
};

var formatNumber = {
    separador: ",", // separador para los miles
    sepDecimal: '.', // separador para los decimales
    formatear: function (num) {
        num += '';
        var splitStr = num.split('.');
        var splitLeft = splitStr[0];
        var splitRight = splitStr.length > 1 ? this.sepDecimal + splitStr[1] : '.00';
        var regx = /(\d+)(\d{3})/;
        while (regx.test(splitLeft)) {
            splitLeft = splitLeft.replace(regx, '$1' + this.separador + '$2');
        }
        return this.simbol + splitLeft + splitRight;
    },
    new : function (num, simbol) {
        this.simbol = simbol || '';
        return this.formatear(num);
    }
};

require(['domReady', 'router','views/AppView'],
    function (domReady, AppRouter, AppView) {

        // domReady is RequireJS plugin that triggers when DOM is ready
        domReady(function () {

            //recuperando el usuario logeado
            app.ls = window.localStorage;
            app.user = JSON.parse(app.ls.getItem('user'));
            
            app.views.appView = new AppView();

            // Start up the application
            app.routers.router = new AppRouter();
            $(".loader").fadeOut();
            Backbone.history.start({
                root : '/',
                pushState:false
            });

        });

    });

