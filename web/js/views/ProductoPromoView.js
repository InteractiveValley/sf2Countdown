define([
    'jquery',
    'underscore',
    'Backbone',
    'models/ProductoModel',
    'text!templates/ProductoPromoView.tpl'
],
        function ($, _, Backbone, ProductoModel, ProductoPromoViewTemplate) {
            var ProductoPromoView = Backbone.View.extend({
                tagName: 'li',
                className: 'producto-promo',
                template: _.template(ProductoPromoViewTemplate),
                initialize: function () {
                    console.log('inicializando productopromoview');
                    this.productoSeleccionado = this.model.attributes.productos[0];
                    this.model.on('destroy', this.destroy_view, this);
                    this.model.on('change', this.render, this);
                },
                events: {
                    'click .modal-producto-agrergar-carrito': 'agregarCarrito',
                    'click .lista-colores-item': 'seleccionarColor',
                    'click .boton-incrementar': 'incrementar',
                    'click .boton-decrementar': 'decrementar'
                },
                agregarCarrito: function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var self = this;
                    var cantidad = this.model.get('cantidad');
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: app.root + '/carrito/add/' + self.productoSeleccionado.id,
                        data: {'cantidad': cantidad},
                        success: function (data) {
                            if (data.status == 'no_existe') {
                                alert("El producto no existe");
                                self.destroy_view();
                            } else if (data.status == 'no_existencia') {
                                alert('El producto ya no tiene existencia');
                            } else if (data.status == 'no_existencia_solicitada') {
                                alert(data.message);
                            } else {
                                alert('El producto fu agregado');
                                console.log('producto ' + data.status);
                                //self.model.set({'cantidad': cantidad});
                                app.collections.carrito.addApartado(data.apartado);
                                //self.destroy_view();
                                app.collections.productos.actualizar(self.model.get('slug'));
                                self.hideModal();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            alert("Error al agregar producto del carrito");
                        }
                    });
                },
                render: function () {
                    console.log('render modalproducto');
                    var data = this.model.toJSON();
                    this.$el.html(this.template({'producto': data}));
                    return this;
                },
                seleccionarColor: function(e){
                    var idColor = $(e.target).data('id');
                    for(var i=this.model.attributes.productos.length-1; i>=0;i--){
                        if(this.model.attributes.productos[i].color.id == idColor){
                           this.productoSeleccionado = this.model.attributes.productos[i];
                           this.mostrarProductoSeleccionado();
                           break;
                        }
                    }
                },
                mostrarProductoSeleccionado: function(){
                    var imagen = this.productoSeleccionado.imagen;
                    this.$el.find('.producto-galeria-imagen').attr({
                      'src': imagen 
                    });
                    this.model.set({cantidad: 1});
                    this.cambioCantidad();
                },
                incrementar: function(){
                    var cantidad = this.model.get('cantidad')+1;
                    if(this.productoSeleccionado.inventario >= cantidad){
                        this.model.set({cantidad: cantidad});
                    }
                    this.cambioCantidad();
                },
                decrementar: function(){
                    var cantidad = this.model.get('cantidad')-1;
                    if(cantidad >= 1){
                        this.model.set({cantidad: cantidad});
                    }
                    this.cambioCantidad();
                },
                cambioCantidad: function(){
                    this.$el.find("#inputCantidad").val(this.model.get('cantidad'));
                },
                destroy_view: function(){
                    // COMPLETELY UNBIND THE VIEW 
                    this.undelegateEvents();
                    this.$el.removeData().unbind();
                    // Remove view from DOM 
                    this.remove();
                    Backbone.View.prototype.remove.call(this);
                }
            });
            return ProductoPromoView;
        });



