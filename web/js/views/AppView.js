define([
    'jquery', 
    'underscore',
    'Backbone'
],
    function ($, _, Backbone) {
        var AppView = Backbone.View.extend({
            el: '#app',
            tagName: 'div',
            //template: _.template( PrincipalViewTemplate),
            initialize: function(){
                console.log('inicializando appview');
            },
            events:{
               'click .item-categoria': 'activarCategoria',
               'click #showCategorias': 'showCategorias',
               'click #showCarrito': 'showCarrito'
            },
            activarCategoria: function(e){
                $(".item-categoria a.link-categoria").removeClass('active');
                $(e.currentTarget).find("a").addClass('active');
            },
            showCategorias: function(e){
                e.preventDefault();
                e.stopPropagation();
                if ($('div.categorias').is(':hidden')) {
                    $('div.categorias').slideDown('fast', function () {
                        $(".cerrar-categorias").html("<i class='fa fa-chevron-down'></i>");
                    });
                } else {
                    $('div.categorias').slideUp('fast', function () {
                        $(".cerrar-categorias").html("<i class='fa fa-list'></i>");
                    });
                }
            },
            showCarrito: function(e){
                e.preventDefault();
                e.stopPropagation();
                if ($('#carrito').is(':hidden')) {
                    $(".filtro-ordenar-por-precio").hide();
                    $("#valor-precio").animate({'fontSize':'12px'},'fast');
                    $("#division-principal,section.productos").animate({'width': '-=266px'},'fast',function(){
                        $("#division-principal,section.productos").resize();
                        $("#carrito").animate({'width':'266px'},'fast').fadeIn('fast');
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
                return this;
            }
        });
        return AppView;
});