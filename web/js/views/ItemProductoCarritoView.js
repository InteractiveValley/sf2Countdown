define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/ProductoModel',
    'models/CronometroModel',
    'text!templates/ItemProductoCarritoInactivoView.tpl',
    'text!templates/ItemProductoCarritoView.tpl'
],
    function ($, _, Backbone, ProductoModel, CronometroModel,  ItemProductoCarritoInactivoViewTemlate,ItemProductoCarritoViewTemplate) {
        var ItemProductoCarritoView = Backbone.View.extend({
            tagName: 'li',
            className: 'item-carrito',
            //template: _.template( PrincipalViewTemplate),
            //template: swig.compile( CarritoViewTemplate ),
            initialize: function() {
		console.log('inicializando itemproductocarritoview');
                this.is_active = true;
                this.reloj = new CronometroModel();
                this.model.on('change', this.render, this);
                this.reloj.on('change:contador',this.renderReloj,this);
            },
            events:{
               'click .close-producto-carrito': 'quitarProductoCarrito',
               'click .tiempo-producto-reactivar': 'reactivarProductoCarrito'
            },
            quitarProductoCarrito: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: window.api.url + '/api/carrito/remove/' + self.model.get('slug'),
                    data: {'cantidad': self.model.get('cantidad')},
                    success: function(data){
                        if(data.status == 'no_existe_apartado'){
                            alert("Apartado no existe");
                            self.destroy_view();
                        }else{
                            self.destroy_view();
                        }
                    },
                    error: function(data){
                        console.log(data);
                        alert("Error al quitar producto del carrito");
                    }
                });
            },
            reactivarProductoCarrito: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: window.api.url + '/api/carrito/add/' + self.model.get('slug'),
                    data: {'cantidad': self.model.get('cantidad')},
                    success: function(data){
                        if(data.status == 'no_existe'){
                            alert("El producto no existe");
                            self.destroy_view();
                        }else if(data.status == 'no_existencia'){
                            alert('El producto ya no tiene existencia');
                        }else if(data.status == 'no_existencia_solicitada' ){
                            alert(data.message);
                        }else{
                            alert('El producto fu reactivado');
                            console.log('producto '+ data.status);
                            self.reloj = new CronometroModel();
                            self.reloj.on('change:contador',self.renderReloj,self);
                        }
                    },
                    error: function(data){
                        console.log(data);
                        alert("Error al agregar producto del carrito");
                    }
                });
            },
            render:function () {
                console.log("render itemproductocarritoview");
                var data = this.model.toJSON();
                if(this.is_active){
                    this.$el.removeClass('inactive');
                    this.$el.html(_.template(ItemProductoCarritoViewTemplate,{'producto':data}));
                }else{
                    this.$el.addClass('inactive');
                    this.$el.html(_.template(ItemProductoCarritoInactivoViewTemlate,{'producto':data}));
                }
                return this;
            },
            renderReloj: function(){
                console.log("render cronometromodel");
                if(this.reloj.get('contador')==0){
                    this.is_active = false;
                    this.render();
                    this.$el.addClass('inactive').removeClass('active');
                    this.reloj.limpiarIntervalo();
                }else{
                    var text = this.reloj.getTimeFormat();
                    this.$el.find('.tiempo-producto-carrito').text(text);
                }
            },
            destroy_view: function() { 
                // COMPLETELY UNBIND THE VIEW 
                this.undelegateEvents(); 
                this.$el.removeData().unbind(); 
                // Remove view from DOM 
                this.remove(); 
                Backbone.View.prototype.remove.call(this); 
            }
        });
        return ItemProductoCarritoView;
});
