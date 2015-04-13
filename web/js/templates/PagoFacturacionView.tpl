    <tr><th>Facturar a:</th></tr>
    <% if( facturacion.isFacturar ) {%>
    <tr>
        <td>
            Rfc: <%= facturacion.rfc %>.
        </td>
    </tr>
    <tr>
        <td>
            Empresa: <%= facturacion.razonSocial %>.
        </td>
    </tr>
    <tr>
        <td>
            Direccion: <%= facturacion.calle %> <%= facturacion.numExterior %> <%= facturacion.numInterior %> <%= facturacion.colonia %> <%= facturacion.cp %> <%= facturacion.municipio %>.
        </td>
    </tr>
    <% } %>
    <tr><td><a href="#facturacion">Editar</a></td></tr>