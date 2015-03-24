        <!--article class="producto imagen_grande o imagen_chica"-->
        <div class="contenido">
            <figure class="imagen-producto">
                <img src="<% print(producto.imagen); %>" alt="imagen de producto"/>
                <figcaption>
                    <span class="precio-producto">
                       <% print(producto.precio_with_format); %> MXN
                    </span>
                    <span class="inventario-producto">
                        Countdown <% print(producto.inventario); %>
                    </span>
                    <span class="agregar-carrito">
                        +<i class="fa fa-shopping-cart"></i>
                    </span>
                    <span class="ver-producto">
                        <i class="fa fa-plus-square"></i>
                    </span>
                </figcaption>
            </figure>
        </div>
        <!--/article-->