<!--section id="registro" class="container"-->
        <div class="row">
            <article id="facturacionView" class="registroView">
                <header>
                    <h2 class="seleccionar-opcion rosa">Facturacion:</h2>
                </header>
                <div class="contenido container">
                    <form class="form-horizontal animate-form" id="formFacturacion" role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-10">
                                        <div class="checkbox">
                                            <label class="control-label">
                                                <input type="checkbox" id="facturacion_isFacturar" name="facturacion_isFacturar" <% if(facturacion.isFacturar==true){%> checked="checked" <%}%>/> Desea recibir factura
                                            </label>
                                            <span class="help-block hidden"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_rfc">Rfc</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_rfc" name="facturacion_rfc" value="<%= facturacion.rfc %>" placeholder="Rfc">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_razonSocial">Razon Social</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_razonSocial" name="facturacion_razonSocial" value="<%= facturacion.razonSocial %>" placeholder="Razon Social">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_calle">Calle</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_calle" name="facturacion_calle" value="<%= facturacion.calle %>" placeholder="Calle">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_numExterior">Num. Exterior</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_numExterior" name="facturacion_numExterior" value="<%= facturacion.numExterior %>" placeholder="Num. Exterior">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_numInterior">Num. Interior</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_numInterior" name="facturacion_numInterior" value="<%= facturacion.numInterior %>" placeholder="Num. Interior">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_cp">Codigo postal</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_cp" name="facturacion_cp" value="<%= facturacion.cp %>" placeholder="Codigo postal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_colonia">Colonia</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_colonia" name="facturacion_colonia" value="<%= facturacion.colonia %>" placeholder="Colonia">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_municipio">Delegacion/Municipio</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_municipio" name="facturacion_municipio" value="<%= facturacion.municipio %>" placeholder="Delegacion/municipio">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_ciudad">Ciudad</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_ciudad" name="facturacion_ciudad" value="<%= facturacion.ciudad %>" placeholder="Ciudad">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_estado">Estado</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_estado" name="facturacion_estado" value="<%= facturacion.estado %>" placeholder="Estado">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_emailEnvio">Email envio</label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" id="facturacion_emailEnvio" name="facturacion_emailEnvio" value="<%= facturacion.emailEnvio %>" placeholder="Email envio">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_contacto">Contacto</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="facturacion_contacto" name="facturacion_contacto" value="<%= facturacion.contacto %>" placeholder="Contacto">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="text-align: left;" class="control-label col-md-2" for="facturacion_telefonoContacto">Telefono / Celular</label>
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control" id="facturacion_telefonoContacto" name="facturacion_telefonoContacto" value="<%= facturacion.telefonoContacto %>" placeholder="Telefono Contacto">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <% if(!facturacion.id){ %>
                                    <div class="form-group">
                                        <button type="button" id="btnSiguiente" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Siguiente</button>
                                    </div>
                                <% }else{ %>
                                    <div class="form-group">
                                        <button type="button" id="btnGuardar" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Guardar</button>
                                        <button type="button" id="btnSiguiente" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Guardar y ver carrito</button>
                                    </div>
                                <% } %>    
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        </div>
<!--section-->