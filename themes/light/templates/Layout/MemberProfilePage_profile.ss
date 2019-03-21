<div class="row">
	<div class="columns twelve">
		<div class="main typography top-panel" role="main" id="main">
			<% with $CurrentMember %>
				<h2>Your Membership</h2>
				<% if $MembershipStatus == 'Applied' %>
					<p class="message success">
						Your application is currently being processed.
					</p>
				<% else_if $MembershipStatus == 'Verified' %>
					<p class="subhead pbl">
						You are a current member of NZLARPS.
					</p>
				<% else_if $MembershipStatus == 'Expired' %>
					<p class="message bad">
						Your membership has expired. To renew your membership, check your details, and submit the form below.
					</p>
				<% else_if $MembershipStatus == 'Not applied' %>
					<p class="message info">
						You have not applied to join NZ Larps, but already have an account.
					</p>
				<% end_if %>

				<% if $NotesForMember %>
					<h3 class="">Messages</h3>
					<p class="subhead pbl">$NotesForMember</p>
				<% end_if %>

				<% if $MemberContent %>
					$MemberContent
				<% end_if %>

				<% if $MembershipStatus != 'Not applied' %>
					<ul class="pbl unstyled text-center">
						<li><strong>Branch:</strong> $Region.Title</li>
						<li><strong>Membership Number:</strong> $MemberNumber</li>
						<li><strong>Expiry Date:</strong> $ExpiryDate</li>
						<li><strong>Discount:</strong> <% if $Discount=='Verified' &&  $DiscountExpiryDate %>Yes - <em>expires $DiscountExpiryDate</em><% else %>No<% end_if %></li>
					</ul>
				<% end_if %>
			<% end_with %>
			$Content.RichLinks
		</div>

		<div class="main mtm">
			<% if $CanAddMembers %>
				<h3><%t MemberProfiles.ADDMEMBER 'Add Member' %></h3>
				<p><%t MemberProfiles.ADDMEMBERLINK 'You can use this page to <a href="{addLink}">add a new member</a>.' addLink=$Link(add) %></p>

				<h3><%t MemberProfiles.YOURPROFILE 'Your Profile' %></h3>
				$Form
			<% else %>
				<% with $CurrentMember %>
					<% if $MembershipStatus == 'Applied' || $MembershipStatus == 'Verified' %>
						<h2>
							Edit your details
						</h2>
					<% else_if $MembershipStatus == 'Expired' %>
						<h2>
							Renew your membership
						</h2>
					<% else_if $MembershipStatus == 'Not applied' %>
						<h2>
							Join NZLarps.
						</h2>
					<% end_if %>
				<% end_with %>
				$Form
			<% end_if %>
		</div>
	</div>
</div>
