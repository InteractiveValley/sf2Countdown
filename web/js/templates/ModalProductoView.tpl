    <!--div id="modalProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 modal-producto-galeria">
                            <span style="display: none;" class="control-producto-galeria control-galeria-izquierdo"><</span>
                            <div class="contendor-producto-galeria">
                                <ul class="producto-galeria-lista">
                                    <li class="producto-galeria-item">
                                        <img class="producto-galeria-imagen" src="<%= producto.productos[0].imagen %>" />
                                    </li>
                                </ul>
                            </div>
                            <span style="display: none;" class="control-producto-galeria control-galeria-derecho">></span>
                        </div>
                        <div class="col-md-6 modal-producto-contenido">
                            <h3 class="modal-producto-titulo"><%= producto.nombre %></h3>
                            <div class="modal-producto-clave-producto">ID: <%= producto.modelo %></div>
                            <div class="modal-producto-descripcion">
                                <%= producto.descripcion %> 
                            </div>
                            <div class="modal-producto-precio">
                               <%= producto.precio_with_format %> MXN
                            </div>
                            <div class="modal-producto-colores">
                                <h3 class="modal-producto-titulo">Color</h3>
                                <br/>
                                <ul class="lista-colores">
                                    <% _.each( producto.productos, function( item ){ %>
                                    <li class="item-color">
                                        <span style="background-color: <%= item.color.color %>;color: <%= item.color.texto %>;" class="lista-colores-item" data-id="<%= item.color.id %>">
                                            <%= item.inventario %>
                                        </span>
                                    </li>
                                    <% }); %>
                                </ul>
                            </div>
                            <span class="modal-producto-inventario">
                                Countdown:  <%= producto.inventario %>
                            </span>
                            <div class="modal-producto-cantidad">
                                <label for="cantidad">Cantidad: </label>
                                <button class="btn btn-default boton-incrementar"><i class="fa fa-plus-square"></i></button>
                                <input type="text" class="form-control" value="<%= producto.cantidad %>" id="inputCantidad" placeholder="" style="width:50px;">
                                <button class="btn btn-default boton-decrementar"><i class="fa fa-minus-square"></i></button>
                            </div>
                            <button class="modal-producto-agrergar-carrito" data-id="<%= producto.id %>">agregar a carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/div-->