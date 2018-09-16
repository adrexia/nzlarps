<% if $getMembersEvents() %>
	<h3>My events</h3>
    <p>All events submitted by $CurrentMember().Name</p>
	<table>
		<thead>
		<tr>
			<th>Title</th>
			<th>Dates</th>
			<th>Created</th>
			<th class="text--center">Edit</th>
			<th class="text--center">Delete</th>

		</tr>
		</thead>
		<tbody>
            <% loop $getMembersEvents() %>
			<tr>
				<td><a href="$InternalLink">$Title</a></td>
				<td>$StartDateTime.format(d M Y) - $EndDateTime.format(d M Y)</td>
				<td>$Created.format(d M Y)</td>
				<td class="text--center"><a href="$getEditLink()">
					<span class="entypo icon-pencil"></span>
				</a></td>
				<td class="text--center"><a href="$getDeleteLink()">
					<span class="entypo icon-trash"></span>
				</a></td>
			</tr>
            <% end_loop %>
		</tbody>
	</table>
<% else %>
	<p>You have no events</p>
<% end_if %>