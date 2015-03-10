define([
    'jquery', 
    'underscore',
    'Backbone',
    'models/ProductoModel',
    'text!templates/ItemProductoView.tpl'
],
    function ($, _, Backbone, ProductoModel  ,ItemProductoViewTemplate) {
        var ItemProductoView = Backbone.View.extend({
            tagName: 'article',
            className: 'producto imagen_chica',
            template: _.template( ItemProductoViewTemplate ),
            initialize: function() {
                console.log('inicializando itemproductoview');
                this.is_active = true;
                this.model.on('change:in_carrito', this.visible,this);
                this.model.on('change', this.render, this);
            },
            events:{
               'click .agregar-carrito':    'agregarCarrito',
               'click .ver-producto':       'verProducto'
            },
            agregarCarrito: function(e){
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                var cantidad = 1;
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: app.root + '/carrito/add/' + self.model.get('slug'),
                    data: {'cantidad': cantidad},
                    success: function(data){
                        if(data.status == 'no_existe'){
                            alert("El producto no existe");
                            self.destroy_view();
                        }else if(data.status == 'no_existencia'){
                            alert('El producto ya no tiene existencia');
                        }else if(data.status == 'no_existencia_solicitada' ){
                            alert(data.message);
                        }else{
                            alert('El producto fu agregado');
                            console.log('producto '+ data.status);
                            self.model.set({'cantidad': cantidad});
                            app.collections.carrito.add(self.model.toJSON());
                            self.model.set({'in_carrito':true});
                        }
                    },
                    error: function(data){
                        console.log(data);
                        alert("Error al agregar producto del carrito");
                    }
                });
            },
            verProducto: function(e){
                e.preventDefault();
                e.stopPropagation();
                app.routers.router.navigate('producto/'+this.model.get('slug'),{trigger: true});
            },
            render:function () {
                var data = this.model.toJSON();
                this.$el.html(this.template({'producto':data}));
                if(this.model.get('isPromocional')){
                   this.$el.addClass('promocional');
                }
                return this;
            },
            enCarrito: function(e){
              e.preventDefault();
              e.stopPropagation();
              if(this.model.get('in_carrito')){
                  var self = this;
                  setTimeout(function(){
                      $(self.el).fadeOut('fast');
                  },500);
              }else{
                  var self = this;
                  setTimeout(function(){
                      $(self.el).fadeIn('fast');
                  },500);
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
        return ItemProductoView;
});



