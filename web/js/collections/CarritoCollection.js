define([
    'underscore',
    'Backbone',
    'models/ApartadoModel'
],
        function (_, Backbone, ApartadoModel) {
            var CarritoCollection = Backbone.Collection.extend({
                url: app.root + "/carrito/productos",
                model: ApartadoModel,
                defaults: {
                    total: 0.0,
                    descuento: 0.0,
                    cuantos: 0
                },
                getTotalesCarrito: function () {
                    this.total = 0.0;
                    this.descuento = 0.0;
                    this.cuantos = 0;
                    var self = this;
                    this.each(function (producto) {
                        if(producto.get('in_carrito')){
                            self.cuantos += parseInt(producto.get('cantidad'));
                            self.total += (producto.get('precio')*producto.get('cantidad'));
                        }
                    });
                    this.descuento = Math.floor(this.cuantos / 3) * 100;
                    return this.getFormateadosTotales();
                },
                getFormateadosTotales: function () {
                    var self = this;
                    return {
                        total: formatNumber.new(self.total, "$"),
                        descuento: formatNumber.new(self.descuento, "$"),
                        cuantos: formatNumber.new(self.cuantos, "")
                    };
                },
                addApartado: function (apartado) {
                    debugger;
                    var localizado = false;
                    for (var i = app.collections.carrito.length-1; i >= 0; i--) {
                        if (apartado.productoId == app.collections.carrito.models[i].get('productoId')) {
                            localizado = true;
                            app.collections.carrito.models[i].set({cantidad: apartado.cantidad});
                            // actualizar el carrito
                            app.views.carrito.renderTotales();
                            break;
                        }
                    }
                    if (!localizado) {
                        app.collections.carrito.add(apartado);
                    }
                    return true;
                },
                actualizar: function (productoId) {
                    var self = this;
                    for (var i = this.models.length-1; i >= 0; i--) {
                        if (this.models[i].get('productoId') == productoId) {
                            var xhr = this.models[i].fetch({data:{'productoId':productoId}});
                            xhr.done(function (data) {
                                self.models[i].set(data);
                                if (self.models[i].get('inventario') == 0) {
                                    self.models[i].trigger('eliminarvista', {eliminar: true});
                                }
                            });
                            break;
                        }
                    }
                }
            });
            return CarritoCollection;
        });

