	<!--section id="registro" class="container"-->
        <div class="row">
            <article id="registroView" class="registroView">
                <div class="contenido container">
                    <form action="/api/registro" class="form validate" role="form" id="formRegistro" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<%= usuario.nombre %>" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="<%= usuario.email %>" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-md-6">
				<div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" id="nombre" name="nombre" value="" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="repetir">Repetir contraseña</label>
                                    <input type="password" class="form-control" id="repetir" name="repetir" value="" placeholder="Repetir password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        </div>
        <!-- PayPal Logo -->
        <table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="#" onclick="javascript:window.open('https://www.paypal.com/mx/cgi-bin/webscr?cmd=xpt/Marketing/general/WIPaypal-outside','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=700, height=600');"><img  src="https://www.paypal.com/es_XC/Marketing/i/banner/paypal_visa_mastercard_amex_debit_new.png" border="0" alt="Comprador local"></a></td></tr></table>
        <!-- PayPal Logo -->
    <--/section-->