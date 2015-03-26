define([
    'jquery',
    'underscore',
    'Backbone',
    'models/ApartadoModel',
    'text!templates/ModalProductoCarritoView.tpl',
    'bootstrap'
],
        function ($, _, Backbone, ApartadoModel, ModalProductoCarritoViewTemplate) {
            var ModalProductoCarritoView = Backbone.View.extend({
                id: 'modalProducto',
                className: 'modal fade',
                template: _.template(ModalProductoCarritoViewTemplate),
                attributes: function(){
                  return {
                    'style'         :"z-index: 2000;",
                    'tabindex'      :"-1",
                    'role'          :"dialog",
                    'aria-labelledby': "",
                    'aria-hidden'   : "true"  
                  };  
                },
                initialize: function () {
                    console.log('inicializando modalproductocarritoview');
                },
                events: {
                    'click .modal-producto-agrergar-carrito': 'actualizarCarrito',
                    'click .boton-incrementar': 'incrementar',
                    'click .boton-decrementar': 'decrementar'
                },
                actualizarCarrito: function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var self = this;
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: app.root + '/carrito/update/' + self.model.get('productoId'),
                        data: {'cantidad': self.model.get('cantidad')},
                        success: function (data) {
                            if (data.status == 'apartado_actualizado') {
                                self.model.set(data.apartado);
                                app.collections.productos.actualizar(self.model.get('slug'));
                                app.views.carrito.renderTotales();
                            } else if (data.status == 'apartado_no_inventario')  {
                                self.model.set(data.apartado);
                                alert("El inventario ha cambiado, disponible: " + data.disponible);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            alert("Error al quitar producto del carrito");
                        }
                    });
                },
                render: function () {
                    console.log('render modalproductocarrito');
                    var data = this.model.toJSON();
                    this.$el.html(this.template({'producto': data}));
                    return this;
                },
                showModal: function(){
                  $(this.el).modal('show');  
                },
                hideModal: function(){
                  $(this.el).modal('hide');  
                },
                incrementar: function(){
                    var cantidad = this.model.get('cantidad')+1;
                    this.model.set({cantidad: cantidad});
                    this.cambioCantidad();
                },
                decrementar: function(){
                    var cantidad = this.model.get('cantidad')-1;
                    this.model.set({cantidad: cantidad});
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
            return ModalProductoCarritoView;
        });