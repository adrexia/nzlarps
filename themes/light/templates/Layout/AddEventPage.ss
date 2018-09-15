<div class="row">
	<div class="columns twelve">
		<div class="top-panel <% if URLSegment == Security %>collapse<% end_if %>" role="main">
			<div class="main">
				<% if $Content %>
				<% include BackButton %>
				$Content.RichLinks.Pagebreaks
				<% end_if %>

				<% if $Form && $CurrentMember && $CurrentMember.MembershipStatus %>

						$Form

				<% end_if %>
			</div>
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

	</div>
</div>
