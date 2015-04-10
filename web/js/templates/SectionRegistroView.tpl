	<!--section id="registro" class="container"-->
        <div class="row">
            <article id="registroView" class="registroView">
                <div class="contenido container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="usuario_nombre">Nombre</label>
                                    <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" value="<%= usuario.nombre %>" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="usuario_email">Email</label>
                                    <input type="text" class="form-control" id="usuario_email" name="usuario_email" value="<%= usuario.email %>" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="usuario_telefono">Telefono</label>
                                    <input type="text" class="form-control" id="usuario_telefono" name="usuario_telefono" value="<%= usuario.telefono %>" placeholder="Telefono">
                                </div>
                            </div>
                            <div class="col-md-6">
				<div class="form-group">
                                    <label for="usuario_password">Contraseña</label>
                                    <input type="password" class="form-control" id="usuario_password" name="usuario_password" value="" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <label for="usuario_repetir">Repetir contraseña</label>
                                    <input type="password" class="form-control" id="usuario_repetir" name="usuario_repetir" value="" placeholder="Repetir password">
                                </div>
                                <div class="form-group">
                                    <button type="button" id="btnRegistro" class="btn btn-default" style="background: #DF2E72; padding: 10px 50px;">Siguiente</button>
                                </div>
                            </div>
                        </div>
                </div>
            </article>
            <article id="envioView" class="registroView">
                <div class="contenido container">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="envio_calle">Calle</label>
                                    <input type="text" class="form-control" id="envio_calle" name="envio_calle" value="<%= envio.calle %>" placeholder="Calle">
                                </div>
                                <div class="form-group">
                                    <label for="envio_cp">Codigo postal</label>
                                    <input type="text" class="form-control" id="envio_cp" name="envio_cp" value="<%= envio.cp %>" placeholder="Codigo postal">
                                </div>
                                <div class="form-group">
                                    <label for="envio_colonia">Colonia</label>
                                    <input type="text" class="form-control" id="envio_colonia" name="envio_colonia" value="<%= envio.cp %>" placeholder="Codigo postal">
                                </div>
                                <div class="form-group">
                                    <label for="envio_municipio">Delegacion/Municipio</label>
                                    <input type="text" class="form-control" id="envio_municipio" name="envio_municipio" value="<%= envio.municipio %>" placeholder="Delegacion/municipio">
                                </div>
                                <div class="form-group">
                                    <label for="envio_estado">Estado</label>
                                    <input type="text" class="form-control" id="envio_estado" name="envio_estado" value="<%= envio.estado %>" placeholder="Estado">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="envio_numExterior">Num. Exterior</label>
                                            <input type="text" class="form-control" id="envio_numExterior" name="envio_numExterior" value="<%= envio.numExterior %>" placeholder="Num. Exterior">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="envio_numInterior">Num. Interior</label>
                                            <input type="text" class="form-control" id="envio_numInterior" name="envio_numInterior" value="<%= envio.numInterior %>" placeholder="Num. Interior">
                                        </div>
                                    </div>    
                                </div>
                                <div class="form-group">
                                    <label for="envio_telefono">Telefono</label>
                                    <input type="text" class="form-control" id="envio_telefono" name="envio_telefono" value="<%= envio.telefono %>" placeholder="Telefono">
                                </div>
                                <div class="form-group">
                                    <label for="envio_observaciones">Observaciones</label>
                                    <textarea class="form-control" rows="4" id="envio_observaciones" name="envio_observaciones">
                                        <%= envio.observaciones %>
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="btnEnvio" class="btn btn-default" style="background: #DF2E72; padding: 10px 50px;">Siguiente</button>
                                </div>
                            </div>
                        </div>
                </div>
            </article>
            <article id="facturacionView" class="registroView">
                <div class="contenido container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox">
                                    <label>
                                      <input type="checkbox" id="facturacion_isFacturar" name="facturacion_isFacturar" value="<%= facturacion.isFacturar %>"> Desea recibir factura
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_rfc">Rfc</label>
                                    <input type="text" class="form-control" id="facturacion_rfc" name="facturacion_rfc" value="<%= facturacion.rfc %>" placeholder="Nombre">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_razonSocial">Razon social</label>
                                    <input type="text" class="form-control" id="facturacion_cp" name="facturacion_razonSocial" value="<%= facturacion.razonSocial %>" placeholder="Razon social">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_calle">Calle</label>
                                    <input type="text" class="form-control" id="facturacion_calle" name="facturacion_calle" value="<%= facturacion.calle %>" placeholder="Calle">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_numExterior">Num. Exterior</label>
                                    <input type="text" class="form-control" id="facturacion_numExterior" name="facturacion_numExterior" value="<%= facturacion.numExterior %>" placeholder="Num. Exterior">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_numInterior">Num. Interior</label>
                                    <input type="text" class="form-control" id="facturacion_numInterior" name="facturacion_numInterior" value="<%= facturacion.numInterior %>" placeholder="Num. Interior">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_cp">Codigo postal</label>
                                    <input type="text" class="form-control" id="facturacion_cp" name="facturacion_cp" value="<%= facturacion.cp %>" placeholder="Codigo postal">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_colonia">Colonia</label>
                                    <input type="text" class="form-control" id="facturacion_colonia" name="facturacion_colonia" value="<%= facturacion.colonia %>" placeholder="Colonia">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_municipio">Delegacion/Municipio</label>
                                    <input type="text" class="form-control" id="facturacion_municipio" name="facturacion_municipio" value="<%= facturacion.municipio %>" placeholder="Delegacion/municipio">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_ciudad">Ciudad</label>
                                    <input type="text" class="form-control" id="facturacion_ciudad" name="facturacion_ciudad" value="<%= facturacion.ciudad %>" placeholder="Ciudad">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_estado">Estado</label>
                                    <input type="text" class="form-control" id="facturacion_estado" name="facturacion_estado" value="<%= facturacion.estado %>" placeholder="Estado">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_emailEnvio">Email envio</label>
                                    <input type="text" class="form-control" id="facturacion_emailEnvio" name="facturacion_emailEnvio" value="<%= facturacion.emailEnvio %>" placeholder="Email envio">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_contacto">Contacto</label>
                                    <input type="text" class="form-control" id="facturacion_contacto" name="facturacion_contacto" value="<%= facturacion.contacto %>" placeholder="Contacto">
                                </div>
                                <div class="form-group">
                                    <label for="facturacion_telefonoContacto">Telefono / Celular</label>
                                    <input type="text" class="form-control" id="facturacion_telefonoContacto" name="facturacion_telefonoContacto" value="<%= facturacion.telefonoContacto %>" placeholder="Telefono Contacto">
                                </div>
                                <div class="form-group">
                                    <button type="button" id="btnFacturacion" class="btn btn-default" style="background: #DF2E72; padding: 10px 50px;">Siguiente</button>
                                </div>
                            </div>
                        </div>
                </div>
            </article>
        </div>
<!--section-->