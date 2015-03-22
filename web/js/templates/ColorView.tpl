<% if(color.checked){ %>
<span style="color: <%= color.color %>" class="color fa <%= color.claseChecked %> <%if(color.inactive){ color.claseInactive } %>"></span>
<% }else{ %>
<span style="color: <%= color.color %>" class="color fa <%= color.claseNoChecked %> <%if(color.inactive){ color.claseInactive } %>"></span>
<% } %>