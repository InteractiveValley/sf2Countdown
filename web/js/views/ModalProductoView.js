define([
    'jquery',
    'underscore',
    'Backbone',
    'models/ProductoModel',
    'text!templates/ModalProductoView.tpl',
    'bootstrap'
],
        function ($, _, Backbone, ProductoModel, ModalProductoViewTemplate) {
            var ModalProductoView = Backbone.View.extend({
                el: $("#modalProducto"),
                template: _.template(ModalProductoViewTemplate),
                initialize: function () {
                    console.log('inicializando modalproductoview');
                    this.productoSeleccionado = this.model.attributes.productos[0];
                },
                events: {
                    'click .modal-producto-agrergar-carrito': 'agregarCarrito',
                    'click .lista-colores-item': 'seleccionarColor'
                },
                agregarCarrito: function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var self = this;
                    var cantidad = 1;
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
                    console.log('render modalproducto');
                    var data = this.model.toJSON();
                    this.$el.html(this.template({'producto': data}));
                    return this;
                },
                showModal: function(){
                  $(this.el).modal('show');  
                },
                cambiarModel: function(model){
                  this.model = model;
                },
                seleccionarColor: function(e){
                    var idColor = $(e.target).data('id');
                    for(var i=0; i<this.model.attributes.productos.length;i++){
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