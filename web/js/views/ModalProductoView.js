define([
    'jquery',
    'underscore',
    'Backbone',
    'models/ProductoModel',
    'text!templates/ModalProductoView.tpl'
],
        function ($, _, Backbone, ProductoModel, ModalProductoViewTemplate) {
            var ModalProductoView = Backbone.View.extend({
                tagName: 'div',
                className: 'modal fade',
                template: _.template(ModalProductoViewTemplate),
                // agregando atributos al modal
                attributes: function () {
                    return {
                        'tabindex': "-1",
                        'role': "dialog",
                        'aria-labelledby': "",
                        'aria-hidden': "true"
                    };
                },
                initialize: function () {
                    console.log('inicializando modalproductoview');
                    this.id = 'modalProducto';
                },
                events: {
                    'click .modal-producto-agrergar-carrito': 'agregarCarrito'
                },
                agregarCarrito: function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var self = this;
                    var cantidad = 1;
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        url: window.api.url + '/api/carrito/add/' + self.model.get('slug'),
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
                                self.model.set({'cantidad': cantidad});
                                app.collections.carrito.add(self.model.toJSON());
                                self.destroy_view();
                            }
                        },
                        error: function (data) {
                            console.log(data);
                            alert("Error al agregar producto del carrito");
                        }
                    });
                },
                render: function () {
                    var data = this.model.toJSON();
                    this.$el.html(this.template({'producto': data}));
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
            return ModalProductoView;
        });