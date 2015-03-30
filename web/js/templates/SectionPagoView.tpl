<article id="pago">
    <div class="row">
        <div class="col-md-8">
            <table class="productos-pago table">
                <tr>
                    <th colspan="2">Articulo</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </table>
        </div>
        <div class="col-md-4">
            <table class="table">
                <tr><th>Enviar a:</th></tr>
                <tr>
                    <td>
                        Direccion del cliente.
                    </td>
                </tr>
                <tr><td><a href="#registro">Editar</a></td></tr>
            </table>
            <table class="table">
                <tr>
                    <td>
                        Subtotal: 
                    </td>
                    <td class="total-importe">
                        <%= carrito.total %> MXN
                    </td>
                </tr>
                <tr>
                    <td>
                        Envio: 
                    </td>
                    <td class="total-envio">
                        <%= 50.00 %> MXN
                    </td>
                </tr>
                <tr>
                    <td>
                        Descuento: 
                    </td>
                    <td class="total-descuento">
                        <%= carrito.descuento %> MXN
                    </td>
                </tr>
            </table>
            <form name='formTpv' method='post' action='https://www.sandbox.paypal.com/cgi-bin/webscr'>
                    <input type='hidden' name='cmd' value='_xclick'>
                    <input type='hidden' name='business' value='mi_cuenta_sandbox@mi_pagina.com'>
                    <input type='hidden' name='item_name' value='Nueva compra en mi web'>
                    <input type='hidden' name='item_number' value='VENTA-X2561'>
                    <input type='hidden' name='amount' value='<%= carrito.total %>'>
                    <input type='hidden' name='page_style' value='primary'>
                    <input type='hidden' name='no_shipping' value='1'>
                    <input type='hidden' name='return' value='http://test.countdown.mx/api/compra/exitosa'>
                    <input type='hidden' name='rm' value='2'>
                    <input type='hidden' name='cancel_return' value='http://test.countdown.mx/api/compra/cancelada'>
                    <input type='hidden' name='no_note' value='1'>
                    <input type='hidden' name='currency_code' value='MXN'>
                    <input type='hidden' name='cn' value='PP-BuyNowBF'>
                    <input type='hidden' name='custom' value=''>
                    <input type='hidden' name='first_name' value='NOMBRE'>
                    <input type='hidden' name='last_name' value='APELLIDOS'>
                    <input type='hidden' name='address1' value='DIRECCIÓN'>
                    <input type='hidden' name='city' value='POBLACIÓN'>
                    <input type='hidden' name='zip' value='CÓDIGO POSTAL'>
                    <input type='hidden' name='night_phone_a' value=''>
                    <input type='hidden' name='night_phone_b' value='TELÉFONO'>
                    <input type='hidden' name='night_phone_c' value=''>
                    <input type='hidden' name='lc' value='es'>
                    <input type='hidden' name='country' value='ES'>
                    <input type="submit" value="Hacer pago"/>
            </form>
        </div>
    </div>
</article>    
