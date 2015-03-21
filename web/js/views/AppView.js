define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/FiltroPrecioModel',
    'collections/ColoresCollection',
    'bootstrap',
    'bootstrap-slider'
],
    function ($, _, Backbone, FiltroPrecioModel, ColoresCollection) {
        var AppView = Backbone.View.extend({
            el: '#app',
            tagName: 'div',
            //template: _.template( PrincipalViewTemplate),
            initialize: function(){
                console.log('inicializando appview');
                this.filtroPrecio = new FiltroPrecioModel();
                this.colores = new ColoresCollection();
                this.colores.fetch();
                this.filtroPrecio.on('change',this.filtrar, this);
            },
            events:{
               'click       .link-categoria':           'activarCategoria',
               'mouseover   .item-navbar-categorias':   'showCategorias',
               'mouseover   .item-navbar-colores':      'showColores',
               'mouseover   .item-navbar-precio':       'showFiltroPrecio',
               'click       #showCarrito':              'showCarrito'
            },
            activarCategoria: function(e){
                alert("activarCategoria");
                e.preventDefault();
                e.stopPropagation();
                $("a.link-categoria").removeClass('active');
                $(e.currentTarget).find("a").addClass('active');
            },
            showCategorias: function(e){
                alert("showCategorias");
                e.preventDefault();
                e.stopPropagation();
                if(this.arreglarMenu()){
                    var self = this;
                    if(this.$el.find('.item-navbar-categorias').css('width')=='100px'){
                        this.$el.find('.item-navbar-colores').fadeOut('fast');
                        this.$el.find('.item-navbar-precio').fadeOut('fast',function(){
                            self.$el.find('.item-navbar-categorias').animate({'width': '600px'},'slow');
                        });
                    }else{
                        this.mostrarMenu();
                    }
                }
            },
            showColores: function(e){
                e.preventDefault();
                e.stopPropagation();
                if(this.arreglarMenu()){
                    var self = this;
                    if(this.$el.find('.item-navbar-colores').css('width')=='100px'){
                        this.$el.find('.item-navbar-precio').fadeOut('fast',function(){
                            self.$el.find('.item-navbar-colores').animate({'width': '600px'},'slow');
                        });
                    }else{
                        this.mostrarMenu();
                    }
                }
            },
            showFiltroPrecio: function(e){
                e.preventDefault();
                e.stopPropagation();
                if(this.arreglarMenu()){
                    var self = this;
                    if(this.$el.find('.item-navbar-precio').css('width')=='100px'){
                        this.$el.find('.item-navbar-precio').animate({'width': '600px'},'slow');
                    }else{
                        this.mostrarMenu();
                    }
                }
            },
            arreglarMenu: function(){
                this.$el.find('.item-navbar-categorias').animate({'width': '100px'},'fast');
                this.$el.find('.item-navbar-colores').animate({'width': '100px'},'fast');
                this.$el.find('.item-navbar-precio').animate({'width': '100px'},'fast');
                return true;
            },
            mostrarMenu: function(){
                this.$el.find('.item-navbar-categorias').fadeIn('fast');
                this.$el.find('.item-navbar-colores').fadeIn('fast');
                this.$el.find('.item-navbar-precio').fadeIn('fast');
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
            sliderPrecio: function(){
                    var self = this;
                    this.$el.find("#sliderPrecio").slider({'tooltip': 'show'});
                    this.$el.find(".slider-horizontal").css({'width': '100%'});
                    this.$el.find("#valor-precio").text( formatNumber.new(2000,"$"));
                    this.$el.find("#sliderPrecio").on('slide', function (ev) {
                        self.$el.find("#valor-precio").text( formatNumber.new(ev.value,"$"));
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