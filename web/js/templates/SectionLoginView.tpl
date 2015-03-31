    <!--section id="login"-->
        <article id="loginView" class="loginView">
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
                            <button type="submit" class="btn btn-danger">Entrar</button>
                            <div style="margin-top: 30px; margin-bottom: 30px">
                                <a href="#recuperar" class="btn btn-success">Olvido su contraseña?</a>
                            </div>    
                        </div>
                        <br />
                    </form>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4 text-center" style="margin-top: 100px;">
                    <a href="#registro" class="btn btn-success btn-block">Registrarse</a>
                </div>
                <div class="col-md-1"></div>
            </div>     
        </article>   
    <!--/section-->