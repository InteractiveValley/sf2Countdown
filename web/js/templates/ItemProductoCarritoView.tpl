                    <!--li class="item-carrito"-->
                        <div class="row">
                            <div class="col-md-4">
                                <figure class="imagen-producto-carrito">
                                    <img src="<%= producto.thumbnail %>" alt="<%= producto.nombre %>"/>
                                    <span class="imagen-producto-cantidad-carrito"><%= producto.cantidad %></span>
                                    <figcaption>
                                        <a href="#producto/carrito/<%= producto.productoId %>">Ver detalles</a>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="col-md-7 producto-carrito">
                                <h6 class="titulo-producto-carrito"><%= producto.nombre %></h6>
                                <span class="precio-producto-carrito">
                                    <%= producto.precio_with_format %> MXN
                                </span>
                                <div class="tiempo-producto">
                                    <span class="tiempo-producto-reloj">
                                        <i class="fa fa-clock-o"></i>
                                    </span>
                                    <span class="tiempo-producto-carrito">
                                        <!-- CronometroModel -->
                                    </span>
                                </div>
                                <span class="close-producto-carrito">
                                    <span style="cursor: pointer;">
                                        <i class="fa fa-times"></i>
                                    </span>
                                </span>
                            </div>
                        </div>
                    <!--/li-->