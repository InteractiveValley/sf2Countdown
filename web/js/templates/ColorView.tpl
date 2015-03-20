<% if(color.checked){ %>
<span class="color <%= color.nombre %> fa <%= color.claseChecked %> <%if(color.inactive){ color.claseInactive } %>"></span>
<% }else{ %>
<span class="color <%= color.nombre %> fa <%= color.claseNoChecked %> <%if(color.inactive){ color.claseInactive } %>"></span>
<% } %>