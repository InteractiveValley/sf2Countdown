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
               'click       .item-categoria':           'activarCategoria',
               'mouseover   .item-navbar-categorias':   'showCategorias',
               'mouseleave  .item-navbar-categorias':   'hideCategorias',
               'mouseover   .item-navbar-colores':      'showColores',
               'mouseleave  .item-navbar-colores':      'hideColores',
               'mouseover   .item-navbar-precio':       'showFiltroPrecio',
               'mouseleave  .item-navbar-precio':       'hideFiltroPrecio',
               
               'click #showCarrito': 'showCarrito'
            },
            activarCategoria: function(e){
                $("a.link-categoria").removeClass('active');
                $(e.currentTarget).find("a").addClass('active');
            },
            showCategorias: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                this.$el.find('.item-navbar-colores').fadeOut('fast').animate({'width': '100px'},'fast');
                this.$el.find('.item-navbar-precio').fadeOut('fast').animate({'width': '100px'},'fast',function(){
                    self.$el.find('.item-navbar-categorias').animate({'width': '600px'},'slow');
                });
            },
            hideCategorias: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                this.$el.find('.item-navbar-categorias').animate({'width': '100px'},'fast',function(){
                    self.$el.find('.item-navbar-colores').fadeIn('fast');
                    self.$el.find('.item-navbar-precio').fadeIn('fast');
                });
            },
            showColores: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                this.$el.find('.item-navbar-precio').animate({'width': '100px'},'fast').fadeOut('fast',function(){
                    self.$el.find('.item-navbar-colores').animate({'width': '600px'},'slow');
                });
            },
            hideColores: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                this.$el.find('.item-navbar-colores').animate({'width': '100px'},'fast',function(){
                    self.$el.find('.item-navbar-precio').fadeIn('fast');
                });
            },
            showFiltroPrecio: function(e){
                e.preventDefault();
                e.stopPropagation();
                this.$el.find('.item-navbar-precio').animate({'width': '600px'},'slow');
            },
            hideFiltroPrecio: function(e){
                e.preventDefault();
                e.stopPropagation();
                this.$el.find('.item-navbar-precio').animate({'width': '100px'},'fast');
            },
            showCarrito: function(e){
                e.preventDefault();
                e.stopPropagation();
                if ($('#carrito').is(':hidden')) {
                    $(".filtro-ordenar-por-precio").hide();
                    $("#valor-precio").animate({'fontSize':'12px'},'fast');
                    $("#division-principal,section.productos").animate({'width': '-=266px'},'fast',function(){
                        $("#division-principal,section.productos").resize();
                        $("#carrito").animate({'width':'266px'},'fast').show('fast');
                    });
                    app.showCarrito=true;
                } else {
                    $("#carrito").fadeOut('fast').animate({'width':'0px'},'fast',function(){
                        $("#division-principal,section.productos").animate({'width': '100%'},'fast',function(){
                            $("#division-principal,section.productos").resize();
                            $("#valor-precio").animate({'fontSize':'16px'},'fast');
                            $(".filtro-ordenar-por-precio").show();
                        });
                    });
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