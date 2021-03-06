<div class="row">
	<div class="columns twelve">
		<div class="top-panel <% if $URLSegment == Security %>collapse<% end_if %>" role="main" id="main">

			<% if $MemberContent %>
				<div class="member">
					<span class="member-meta">nzlarps member content</span>
					$MemberContent
				</div>
			<% end_if %>

			<% if $Content %>
				<% include BackButton %>
				$Content.RichLinks.Pagebreaks
			<% end_if %>

			<% if $Form || $SlackSignupForm %>
				<div class="main">
					$Form
					<div class="slackform">
					$SlackSignupForm
					</div>
				</div>
			<% end_if %>
			
			</div>


		<% if $CurrentFeatureItems %>
			<div class="ptl">
				<% include Features %>
			</div>
		<% end_if %>

		<% if $ExtraContent %>
		<div class="mtm">
			$ExtraContent.RichLinks.Pagebreaks
		</div>
		<% end_if %>



		<% if $ClassName=='RegistrationPage' %>
			<footer class="content-footer columns twelve">
			</footer>
		<% else %>
			<footer class="content-footer columns twelve">
				<% include LastEdited %>
			</footer>
		<% end_if %>
	</div>
</div>
