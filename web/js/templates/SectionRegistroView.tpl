<!--section id="registro" class="container"-->
        <div class="row">
            <article id="registroView" class="registroView">
                <header>
                    <h2 class="seleccionar-opcion rosa">
                        <% if(usuario.nombre.length>0){ %>
                        Usuario: <%= usuario.nombre %>
                        <%}else{%>
                        Crear cuenta
                        <% } %>
                    </h2>
                </header>
                <div class="contenido container">
                    <form class="form-horizontal animate-form" id="formRegistro" role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="usuario_nombre">Nombre</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="usuario_nombre" name="usuario_nombre" value="<%= usuario.nombre %>" placeholder="Nombre">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="usuario_email">Email</label>
                                    <div class="col-md-12">
                                        <input type="email" class="form-control" id="usuario_email" name="usuario_email" value="<%= usuario.email %>" placeholder="Email">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="usuario_telefono">Telefono</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="usuario_telefono" name="usuario_telefono" value="<%= usuario.telefono %>" placeholder="Telefono">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
				<div class="form-group">
                                    <label class="control-label col-md-2" for="usuario_password">Contraseña</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" id="usuario_password" name="usuario_password" value="" placeholder="Contraseña">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="usuario_repetir">Repetir</label>
                                    <div class="col-md-12">
                                        <input type="password" class="form-control" id="usuario_repetir" name="usuario_repetir" value="" placeholder="Repetir contraseña">
                                        <span class="help-block hidden"></span>
                                    </div>
                                </div>
                                <br/>
                                <% if(!usuario.id){ %>
                                <div class="form-group">
                                    <button type="button" id="btnSiguiente" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Siguiente</button>
                                </div>
                                <% }else{ %>
                                <div class="form-group">
                                    <button type="button" id="btnGuardar" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Guardar</button>
                                    <button type="button" id="btnSiguiente" class="btn btn-default" style="background: #DF2E72;color: white; padding: 10px 50px;">Guardar y editar envio</button>
                                </div>
                                <% } %>    
                            </div>
                        </div>
                    </form>
                </div>
            </article>
        </div>
<!--section-->