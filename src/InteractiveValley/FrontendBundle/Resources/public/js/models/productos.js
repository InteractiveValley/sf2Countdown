Countdown.Models.Producto = Backbone.Model.extend({
    defaults: {
      nombre: '',
      slug: '',
      existencia: 0,
      reservado: 0,
      precio: 0.0,
      in_carrito: false,
    },
    getPrecioFormat: function(){
        return formato_numero(precio, 2, ".", ",");
    },
    getTiempoFormat: function(){
        return "20 min 5 seg";
    }
});

Countdown.Collections.Productos = Backbone.Collection.extend({
    model: Countdown.Models.Producto,
    desactivarTodas: function(){
       _.each(this.collection, function(model){ 
          if(model.get('activa')==true){
              model.set('activa',false);
          }
      });
    }
});

Countdown.Collections.Carrito = Backbone.Collection.extend({
    model: Countdown.Models.Producto
});

function formato_numero(numero, decimales, separador_decimal, separador_miles){ 
    numero=parseFloat(numero);
    if(isNaN(numero)){
        return "";
    }

    if(decimales!==undefined){
        // Redondeamos
        numero=numero.toFixed(decimales);
    }

    // Convertimos el punto en separador_decimal
    numero=numero.toString().replace(".", separador_decimal!==undefined ? separador_decimal : ",");

    if(separador_miles){
        // Añadimos los separadores de miles
        var miles=new RegExp("(-?[0-9]+)([0-9]{3})");
        while(miles.test(numero)) {
            numero=numero.replace(miles, "$1" + separador_miles + "$2");
        }
    }

    return numero;
}