<!--section id="registro" class="container"-->
        <div class="row">
            <article id="envioView" class="registroView">
                <header>
                    <h2 class="seleccionar-opcion rosa">Direccion de envio:</h2>
                </header>
                <div class="contenido container">
                    <form class="form-horizontal animate-form" id="formEnvio" role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="envio_calle">Calle</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="envio_calle" name="envio_calle" value="<%= envio.calle %>" placeholder="Calle">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4" style="text-align: left;" for="envio_cp">Codigo postal</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="envio_cp" name="envio_cp" value="<%= envio.cp %>" placeholder="Codigo postal">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="envio_colonia">Colonia</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="envio_colonia" name="envio_colonia" value="<%= envio.colonia %>" placeholder="Colonia">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="envio_municipio">Delegacion/Municipio</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="envio_municipio" name="envio_municipio" value="<%= envio.municipio %>" placeholder="Delegacion/Municipio">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="envio_estado">Estado</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="envio_estado" name="envio_estado" value="<%= envio.estado %>" placeholder="Estado">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="text-align: left;" class="control-label col-md-6" for="envio_numExterior">Num. Exterior</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" id="envio_numExterior" name="envio_numExterior" value="<%= envio.numExterior %>" placeholder="Num. Exterior">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label style="text-align: left;" class="control-label col-md-6" for="envio_numInterior">Num. Interior</label>
                                            <div class="col-md-12">
                                                <input type="text" class="form-control" id="envio_numInterior" name="envio_numInterior" value="<%= envio.numInterior %>" placeholder="Num. Interior">
                                                <span class="help-block hidden"></span>
                                            </div>
                                        </div>
                                    </div>    
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="envio_telefono">Telefono</label>
                                    <div class="col-md-12">
                                        <input type="tel" class="form-control" id="envio_telefono" name="envio_telefono" value="<%= envio.telefono %>" placeholder="Telefono">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="envio_observaciones">Observaciones</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" rows="4" id="envio_observaciones" name="envio_observaciones"><%= envio.observaciones %></textarea>
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <% if(!envio.id){ %>
                                <div class="form-group">
                                    <button type="button" id="btnSiguiente" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Siguiente</button>
                                </div>
                            <% }else{ %>
                                <div class="form-group">
                                    <button type="button" id="btnGuardar" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Guardar</button>
                                    <button type="button" id="btnSiguiente" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Guardar y editar facturacion</button>
                                </div>
                            <% } %>    
                        </div>
                    </form>
                </div>
            </article>
        </div>
<!--section-->