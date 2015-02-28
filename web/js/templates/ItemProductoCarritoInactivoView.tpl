                    <!--li class="item-carrito inactive"-->
                        <div class="row">
                            <div class="col-md-4">
                                <figure class="imagen-producto-carrito">
                                    <img src="<%= producto.thumbnail %>" alt="<%= producto.nombre %>"/>
                                    <span class="reloj-inactivo">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                </figure>
                            </div>
                            <div class="col-md-7 producto-carrito">
                                <h6 class="titulo-producto-carrito"><%= producto.nombre %></h6>
                                <span class="precio-producto-carrito">
                                    <%= producto.precio_with_format %> MXN
                                </span>
                                <div class="tiempo-producto-completo">
                                    <span class="tiempo-producto-reactivar">
                                        Countdown terminado.<br/>
                                        ¿Agregarlo de nuevo?
                                    </span>
                                </div>
                            </div>
                        </div>
                    <!--/li-->