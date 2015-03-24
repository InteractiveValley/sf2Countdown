define([
    'underscore',
    'Backbone',
    'models/ProductoModel'
],
        function (_, Backbone, ProductoModel) {
            var ProductosCollection = Backbone.Collection.extend({
                url: app.root + "/modelos",
                model: ProductoModel,
                filtrarPorPrecio: function (valor) {
                    var i = this.models.length - 1;
                    var visibleModel = true;
                    for (; i >= 0; i--) {
                        visibleModel = (this.models[i].get('precio') <= valor)
                        this.models[i].set({'visible': visibleModel});
                    }
                },
                actualizar: function (slug) {
                    var self = this;
                    for (var i = this.models.length-1; i >= 0; i--) {
                        if (this.models[i].get('slug') == slug) {
                            var xhr = this.models[i].fetch();
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
            return ProductosCollection;
        });

