<% if $getMembersEvents() %>
	<h3>My events</h3>
    <p>All events submitted by $CurrentMember().Name</p>
	<table>
		<thead>
		<tr>
			<th>Title</th>
			<th>Start Date</th>
			<th>Finish Date</th>
			<th>Created</th>
			<th><span class="entypo icon-pencil"></span>Edit</th>
		</tr>
		</thead>
		<tbody>
            <% loop $getMembersEvents() %>
			<tr>
				<td><a href="$InternalLink">$Title</a></td>
				<td>$StartDateTime.format(d M Y)</td>
				<td>$EndDateTime.format(d M Y)</td>
				<td>$Created.format(d M Y)</td>
				<td><a class=" " href="$getEditLink()">
					<span class="entypo icon-pencil"></span>
				</a></td>
			</tr>
            <% end_loop %>
		</tbody>
	</table>
<% end_if %>