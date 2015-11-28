<div class="row">

	<div class="columns twelve">
		<div class="top-panel" role="main" id="main">
			<% include BackButton Parent=$getParent() %>
			$Content.RichLinks.Pagebreaks
			$Form
		</div>

		<% if $Events %>
			<h2 class="text-center listing-heading first">Upcoming Events</h2>
			<div class="Events ptl">
				<% include EventListEvents Events=$Events, Short="Short" %>
			</div>


		<% end_if %>



		<h2 class="text-center listing-heading <% if not $Events %>first<% end_if %>">All Regions</h2>
		<div class="row block-container">
			<% loop CurrentRegions %>
			<div class="block-link">
				<a class="$Colour" href="$Top.Link{$URLSegment}">
					<h3>$Title</h3>
				</a>
			</div>
			<% end_loop %>

		</div>

		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
