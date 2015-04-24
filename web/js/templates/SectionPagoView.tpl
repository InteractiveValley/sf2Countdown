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
            <table id="tableEnvio" class="table">

            </table>
            <table id="tableFacturacion" class="table">
                
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
            
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="richpolis@gmail.com">
            <input type="hidden" name="lc" value="MX">
            <input type="hidden" name="item_name" value="Compra en tienda online">
            <input type="hidden" name="item_number" value="1234567">
            <input type="hidden" name="amount" value="<%= carrito.total %>">
            <input type="hidden" name="currency_code" value="MXN">
            <input type="hidden" name="button_subtype" value="services">
            <input type="hidden" name="tax_rate" value="16.000">
            <input type="hidden" name="shipping" value="50.00">
            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHosted">
            <input type="image" src="https://www.paypalobjects.com/es_XC/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="PayPal, la forma más segura y rápida de pagar en línea.">
            <img alt="" border="0" src="https://www.paypalobjects.com/es_XC/i/scr/pixel.gif" width="1" height="1">
            </form>

        </div>
    </div>
</article>    
