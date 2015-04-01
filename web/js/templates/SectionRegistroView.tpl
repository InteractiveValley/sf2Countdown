	<!--section id="registro" class="container"-->
        <div class="row">
            <article id="registroView" class="registroView">
                <div class="contenido container">
                    <form action="/api/registro" class="form validate" role="form" id="formRegistro" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="nombre">Nombre</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre">
									</div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-3" for="nombre">Nombre</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre">
									</div>
                                </div>
								<div class="form-group">
                                    <label class="control-label col-lg-3" for="nombre">Nombre</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre">
									</div>
                                </div>
								<div class="form-group">
                                    <label class="control-label col-lg-3" for="nombre">Nombre</label>
									<div class="col-lg-9">
										<input type="text" class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre">
									</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{ form_row(form.password,{'attr':{'class':'form-control','label':'Contraseña','placeholder':'Contraseña'}}) }}
                                </div>    
                            </div>
                        </div>
                        <br/>
                        {{form_rest(form)}}
                        <div class="row">
                            <div class="col-md-6"><button type="submit" class="btn btn-default" style="background-color: #DF2E72; color: white;">Registrar</button></div>
                            <div class="col-md-6"></div> 
                        </div>
                        <br/>
                    </form>
                </div>
            </article>
        </div>
		<!-- PayPal Logo --><table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="#" onclick="javascript:window.open('https://www.paypal.com/mx/cgi-bin/webscr?cmd=xpt/Marketing/general/WIPaypal-outside','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=700, height=600');"><img  src="https://www.paypal.com/es_XC/Marketing/i/banner/paypal_visa_mastercard_amex_debit_new.png" border="0" alt="Comprador local"></a></td></tr></table><!-- PayPal Logo -->
    <--/section-->