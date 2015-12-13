<p>This is a daily summary of all pending, expiring, and recently expired memberships. To manage memberships, visit <a href="http://nzlarps.org/admin/security/">the NZLarps Membership admin</a>.</p>

<% if $NewMembers %>
	<h4>Applying Members</h4>
	<em>Memberships not yet verified</em>
	<p>The treasurer should confirm payment and change the membership status to 'Verified'. This will automatically generate both the membership number and the joined date if they do not yet exist.</p>

	<ul>
		<% loop $NewMembers %>
			<li>$FirstName $Surname ($Email)</li>
		<% end_loop %>
	</ul>
<% end_if %>

<% if $ExpiredMembers %>
	<h4>Expired Members</h4>
	<em>Memberships elapsed yesterday</em>
	<p>
	These members have been notified that their membership has elapsed. If a renewal payment comes through for an expired member, set their membership status to 'Verified'. They will then need to be notified that their renewal is complete.
	</p>

	<ul>
		<% loop $ExpiredMembers %>
			<li>$FirstName $Surname ($Email)</li>
		<% end_loop %>
	</ul>
<% end_if %>

<% if $ExpiringMembers %>
	<h4>Expiring Members</h4>
	<em>Memberships due to expire in the next 30 days</em>
	<p>
	These members have been notified that their membership is due to elapse within the next 30 days.
	</p>

	<ul>
		<% loop $ExpiringMembers %>
			<li>$FirstName $Surname ($Email)</li>
		<% end_loop %>
	</ul>
<% end_if %>
