    <!--div id="modalProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 modal-producto-galeria">
                            <ul class="bxslider">
                                <% _.each( producto.galerias, function( galeria ){ %>
                                <li><img src="<%= galeria.imagen %>" /></li>
                                <% }); %>    
                            </ul>
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
                            <span class="modal-producto-inventario">
                                Countdown:  <%= producto.existencia %>
                            </span>
                            <form class="form-inline modal-producto-cantidad">
                                <div class="form-group">
                                    <label for="cantidad">Cantidad: </label>
                                    <input type="text" class="form-control" id="cantidad" placeholder="" style="width:100px;">
                                    <button class="btn btn-default"><i class="fa fa-plus-square"></i></button>
                                    <button class="btn btn-default"><i class="fa fa-minus-square"></i></button>
                                </div>
                            </form>
                            <button class="modal-producto-agrergar-carrito" data-id="<%= producto.id %>">agregar a carrito</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!--/div-->