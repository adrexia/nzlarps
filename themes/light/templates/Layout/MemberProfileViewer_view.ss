<% require css(memberprofiles/css/MemberProfileViewer.css) %>

<div class="row">
	<% include Breadcrumbs %>
	<div class="row">
		<% include SecondaryMenu %>
		<div class="columns nine">
			<div class="main typography top-panel" role="main" id="main">
				<h1 class="page-header">$Title</h1>
				<div class="content member-profile<% if IsSelf %> member-profile-self<% end_if %>">$Content

					<% if IsSelf %>
						<p class="message"><%t MemberProfiles.THISISYOURPROFILE 'This is your profile!' %> <a href="$Parent.Link"><%t MemberProfiles.EDITPROFILE 'Edit Profile' %></a></p>
					<% end_if %>
					<% loop Sections %>
						<div id="$ClassName" class="member-profile-section">
							<% if ShowTitle %><h3>$Title</h3><% end_if %>
							$Me
						</div>
					<% end_loop %>

					$Form

					$PageComments
				</div>
			</div>
		</div>
	</div>
</div>
