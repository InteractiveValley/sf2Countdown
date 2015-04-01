    <!--section id="login"-->
        <article id="loginView" class="loginView">
			<header>
				<h2 class="login-seleccionar-opcion">Seleccione una opcion</h2>
			</header>
			<div class="contenido row">
                <div class="col-md-6">
					<h3 class="login-titulo">ingresar con cuenta y hacer pedido</h3>
                </div>
                <div class="col-md-6 text-center">
					<h3 class="login-titulo">registrar mis datos y hacer pedido</h3>
                </div>
            </div>
            <div class="contenido row">
                <div class="col-md-6">
                    <!-- Login form -->
                    <form class="form-horizontal" action='/login_check' role="form"  method="post">
                        <!-- Email -->
                        <div class="form-group">
                            <label class="control-label col-lg-3" for="username">Email</label>
                            <div class="col-lg-9">
                                <input type="email" class="form-control" id="username" name="_username" value="<%= usuario.email %>" placeholder="Email">
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <label class="control-label col-lg-3" for="password">Contraseña</label>
                            <div class="col-lg-9">
                                <input type="password" class="form-control"  id="password" name="_password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-lg-9 col-lg-offset-3">
                            <button type="submit" class="btn btn-danger" style="background: #DF2E72;">Entrar</button>
                            <div style="margin-top: 30px; margin-bottom: 30px">
                                <a href="#recuperar" class="btn btn-success">Olvido su contraseña?</a>
                            </div>    
                        </div>
                        <br />
                    </form>
                </div>
                <div class="col-md-6 text-center" style="margin-top: 100px;">
                    <a href="#registro" class="btn btn-success btn-lg" style="background: #DF2E72;">Registrarse</a>
                </div>
            </div>     
        </article>   
    <!--/section-->