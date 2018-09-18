<div class="row">
	<div class="columns twelve">
		<div class="top-panel main" role="main">
			$Content.RichLinks
		</div>
		<div class="main mtm">


			<% if $Form && $CurrentMember && $CurrentMember.MembershipStatus %>
				<h2>Event Details</h2>

				$Form

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

	</div>
</div>
