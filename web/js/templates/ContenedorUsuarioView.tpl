<!--div class="contenedor-usuario"-->
   <% if(usuario.nombre) { %>
   <span class="contenido-usuario-crear-cuenta">
        <a href="#registro"><%= usuario.nombre %></a>
    </span>
    <span class="contenido-usuario-login">
        <a href="/logout">Cerrar</a>
    </span>
   <% }else{ %>
    <span class="contenido-usuario-crear-cuenta">
        <a href="#registro">Crear cuenta</a>
    </span>
    <span class="contenido-usuario-login">
        <a href="#login">Login</a>
    </span>
   <% } %>
    &nbsp;
    <span class="contenido-usuario-tracking">
        <a href="#tracking">tracking</a>
    </span>
<!--/div-->