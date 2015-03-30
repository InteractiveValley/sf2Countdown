define([
    'jquery',
    'underscore',
    'Backbone',
    'text!templates/ItemProductoPagoView.tpl'
],
        function ($, _, Backbone, ItemProductoPagoViewTemplate) {
            var ItemProductoPagoView = Backbone.View.extend({
                tagName: 'tr',
                className: 'item-pago',
                initialize: function () {
                    debugger;
                    //this.model = config.model;
                    console.log('inicializando itemproductocarritoview');
                    this.model.on('change:cantidad', this.render, this);
                    this.model.on('destroy', this.destroy_view, this);
                    this.status = '';
                },
                events: {
                    
                },
                quitarProductoCarrito: function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (confirm('Desea quitar el producto de su carrito?')) {
                        this.quitarApartado();
                    }
                },
                quitarApartado: function () {
                    var self = this;
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: app.root + '/carrito/remove/' + self.model.get('productoId'),
                        data: {'cantidad': self.model.get('cantidad')},
                        success: function (data) {
                            if (data.status == 'no_existe_apartado') {
                                alert("Apartado no existe");
                            }
                            self.reloj.limpiarIntervalo();
                            if(app.collections.productos){
                                app.collections.productos.actualizar(self.model.get('slug'));
                            }
                            var models = app.collections.carrito.where({'productoId':self.model.get('productoId')});
                            app.collections.carrito.remove(models);
                            self.destroy_view();
                        },
                        error: function (data) {
                            console.log(data);
                            alert("Error al quitar producto del carrito");
                        }
                    });
                },
                actualizarApartado: function (cant) {
                    var self = this;
                    var cantidad = cant;
                    this.model.set({cantidad: cantidad});
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: app.root + '/carrito/update/' + self.model.get('productoId'),
                        data: {'cantidad': self.model.get('cantidad')},
                        success: function (data) {
                            debugger;
                            if (data.status == 'apartado_actualizado') {
                                self.model.set(data.apartado);
                                if(app.collections.productos){
                                    app.collections.productos.actualizar(self.model.get('slug'));
                                }
                                app.views.carrito.renderTotales();
                            } else if (data.status == 'apartado_no_inventario')  {
                                self.model.set(data.apartado);
                                alert("El inventario ha cambiado, disponible es: " + data.disponible);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            alert("Error al quitar producto del carrito");
                        }
                    });
                },
                render: function () {
                    var data = this.model.toJSON();
                    this.$el.html(_.template(ItemProductoPagoViewTemplate, {'producto': data}));
                    return this;
                },
                destroy_view: function () {
                    // COMPLETELY UNBIND THE VIEW 
                    this.undelegateEvents();
                    this.$el.removeData().unbind();
                    // Remove view from DOM 
                    this.remove();
                    Backbone.View.prototype.remove.call(this);
                }
            });
            return ItemProductoPagoView;
        });

