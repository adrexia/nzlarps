<div class="row">
	<div class="columns twelve">
		<div class="top-panel <% if URLSegment == Security %>collapse<% end_if %>" role="main" id="main">
			<% if $Content %>
			<% include BackButton %>
			$Content.RichLinks.Pagebreaks
			<% end_if %>

			<% if $Form %>
			<div class="main">
				$Form
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
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
