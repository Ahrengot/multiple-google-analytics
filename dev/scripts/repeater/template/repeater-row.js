export default `
  <th scope="row"><%= index %></th>
  <td>
    <div class="ahr-repeater-row-content">
      <% if ( state === 'edit' ) { %>
        <input name="<%= name %>" value="<%= value %>" placeholder="<%= placeholder %>" tabindex="<%= index %>">
      <% } else { %>
        <span class="row-value"><%= value %></span>
      <% } %>
      <button type="button" class="btn-delete" aria-label="<%= deleteLabel %>" title="<%= deleteLabel %>" tabindex="<% print(parseInt(index, 10) + 1) %>">&times;</button>
    </div>
  </td>
`