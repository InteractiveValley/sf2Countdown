    <!--section id="login"-->
        <article id="loginView" class="loginView">
            <header>
                <h2 class="seleccionar-opcion">Seleccione una opcion</h2>
            </header>
            <div class="contenido row" style="margin-left: 0px; margin-right: 0px;">
                <div class="col-md-6 text-center">
                   <h3 class="login-titulo">ingresar con cuenta y hacer pedido</h3>
                </div>
                <div class="col-md-6 text-center">
                    <h3 class="login-titulo">registrar mis datos y hacer pedido</h3>
                </div>
            </div>
            <div class="contenido row border-top-gradiente">
                <div class="col-md-6 bloque-login" style="padding-top: 30px; padding-bottom: 100px;">
                    <div class="alert alert-danger" style="display: none;" id="mensajeError"></div>
                    <!-- Login form -->
                    <form id="formLogin" class="form-horizontal" action='/login_check' role="form"  method="post" style="padding-left: 20px; padding-right: 20px;">
                        <!-- Email -->
                        <div class="form-group">
                            <label class="control-label" for="username">Email</label>
                            <input type="email" class="form-control" id="username" name="_username" value="<%= usuario.email %>" placeholder="Email">
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="control-label" for="password">Contraseña</label>
                            <input type="password" class="form-control"  id="password" name="_password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger" style="background: #DF2E72; padding: 10px 50px;">Entrar</button>
                            <a href="#recuperar" class="btn btn-link">Olvido su contraseña?</a>
                        </div>
                        <br />
                    </form>
                </div>
                <div class="col-md-6 text-center bloque-login" style="padding-top: 100px;">
                    <a href="#registro" class="btn btn-success" style="background: #DF2E72; border-color: #DF2E72;padding: 10px 50px;">Registrarse</a>
                </div>
            </div>     
        </article>   
    <!--/section-->