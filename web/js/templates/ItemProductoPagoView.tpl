<!--tr class="item-pago"-->
        <td class="imagen-producto-pago">
                <img src="<%= producto.imagen %>" alt="<%= producto.nombre %>" style="max-width: 100%;"/>
        </td>
        <td class="producto-pago-nombre">
            <%= producto.nombre %>
            <br/>
            <%= producto.color.nombre %>
        </td>
        <td class="producto-pago-precio">
            <%= producto.precio_with_format %> MXN
        </td>
        <td class="producto-pago-cantidad">
            <%= producto.cantidad_with_format %>
        </td>
        <td class="producto-pago-importe">
            <%= producto.importe_with_format %> MXN
        </td>
        <a class="eliminar-producto-pago">Elimianr</a>
<!--/tr-->