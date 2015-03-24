define([
    'underscore',
    'Backbone',
    'models/ProductoModel'
],
        function (_, Backbone, ProductoModel) {
            var CarritoCollection = Backbone.Collection.extend({
                url: app.root + "/carrito/productos",
                model: ProductoModel,
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
                            self.cuantos += producto.get('cantidad');
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
				addApartado: function(apartado){
					debugger;
					var localizado = false;
					for(var i = app.collections.carrito.length; i>=0;i--){
						if(apartado.id == app.collections.carrito.models[i].get('id')){
							localizado = true;
							app.collections.carrito.models[i].set({cantidad: apartado.cantidad});
							break;
						}
					}
					if(!localizado){
						this.add(apartado);
					}
					return true;
				}
            });
            return CarritoCollection;
        });

