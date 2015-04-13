define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/FiltroPrecioModel',
    'models/UsuarioModel',
    'models/EnvioModel',
    'models/FacturacionModel',
    'collections/ColoresCollection',
    'views/ColorView',
    'text!templates/ContenedorUsuarioView.tpl',
    'bootstrap',
    'bootstrap-slider'
],
    function ($, _, Backbone, FiltroPrecioModel, UsuarioModel, EnvioModel, FacturacionModel, ColoresCollection, ColorView, ContenedorUsuarioViewTemplate) {
        var AppView = Backbone.View.extend({
            el: '#app',
            tagName: 'div',
            //template: _.template( PrincipalViewTemplate),
            initialize: function(){
                console.log('inicializando appview');
                this.filtroPrecio = new FiltroPrecioModel();
                this.colores = new ColoresCollection();
                app.user = new UsuarioModel();
                app.envio = new EnvioModel();
                app.envio.fetch();
                app.facturacion = new FacturacionModel();
                app.facturacion.fetch();
                var xhr = this.colores.fetch();
                var self = this;
                xhr.done(function(){
                    self.renderColores();
                });
                var xhru = app.user.fetch();
                xhru.done(function(){
                    self.renderUsuario();
                });
                this.filtroPrecio.on('change',this.filtrar, this);
                app.user.on('change',this.renderUsuario, this);
                this.statusMenu = '';
                this.sliderPrecio();
            },
            events:{
               'click       .link-categoria':           'activarCategoria',
               'click       #showCategorias':           'showCategorias',
               'click       #showColores':              'showColores',
               'click       #showFiltroPrecio':         'showFiltroPrecio',
               'click       #showCarrito':              'showCarrito',
               'click       #showPromos':               'showPromos',
               'mouseleave  nav':                       'hideOpcionesMenu'
            },
            activarCategoria: function(e){
                $("a.link-categoria").removeClass('active');
                $(e.currentTarget).find("a").addClass('active');
            },
            showCategorias: function(e){
                e.preventDefault();
                e.stopPropagation();
                if(this.hideOpcionesMenu()){
                    this.$el.find('.contenedor-filtro-navbar.contenedor-categorias').fadeIn('fast');
                }
            },
            showColores: function(e){
                e.preventDefault();
                e.stopPropagation();
                if(this.hideOpcionesMenu()){
                    this.$el.find('.contenedor-filtro-navbar.contenedor-colores').fadeIn('fast');
                }
            },
            showFiltroPrecio: function(e){
                e.preventDefault();
                e.stopPropagation();
                if(this.hideOpcionesMenu()){
                    this.$el.find('.contenedor-filtro-navbar.contenedor-precio').fadeIn('fast');
                }
            },
            showPromos: function(e){
                e.preventDefault();
                e.stopPropagation();
                this.hideOpcionesMenu();
                app.routers.router.navigate('categoria/promos',{trigger: true});
            },
            hideOpcionesMenu: function(){
                this.$el.find('.contenedor-filtro-navbar.contenedor-categorias').fadeOut('fast');
                this.$el.find('.contenedor-filtro-navbar.contenedor-colores').fadeOut('fast');
                this.$el.find('.contenedor-filtro-navbar.contenedor-precio').fadeOut('fast');
                return true;
            },
            showCarrito: function(e){
                e.preventDefault();
                e.stopPropagation();
                if ($('#carrito').is(':hidden')) {
                    $("#carrito").fadeIn('fast');
                    app.showCarrito=true;
                } else {
                    $("#carrito").fadeOut('fast');
                    app.showCarrito=false;
                }
            },
            render:function () {
                this.sliderPrecio();
                return this;
            },
            renderColores:function () {
                var colorView;
                var self = this;
                this.colores.forEach(function(model){
                    colorView = new ColorView({model: model});
                    self.$el.find('.contenedor-filtro-navbar.contenedor-colores').append(colorView.render().$el.html());
                });
                return this;
            },
            renderUsuario:function () {
                var data = app.user.toJSON();
                var html = _.template(ContenedorUsuarioViewTemplate, {'usuario': data});
                return this.$el.find('.contenedor-usuario').html(html);
            },
            sliderPrecio: function(){
                var self = this;
                this.$el.find("#sliderPrecio").slider({'tooltip': 'show'});
                this.$el.find(".slider-horizontal").css({'width': '100%'});
                this.$el.find("#valor-precio").text(formatNumber.new(2000, "$"));
                this.$el.find("#sliderPrecio").on('slide', function (ev) {
                    self.$el.find("#valor-precio").text(formatNumber.new(ev.value, "$"));
                    self.filtroPrecio.set({'value': ev.value});
                }).on("slideStop", function (ev) {

                });
            },
            filtrar: function(){
                app.collections.productos.filtrarPorPrecio(this.filtroPrecio.get('value'));
            }
        });
        return AppView;
});