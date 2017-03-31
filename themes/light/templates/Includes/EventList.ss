<div class="row">
	<div class="columns twelve">
		<div class="main top-panel calendar" role="main" id="main">
			<h2>Upcoming Events</h2>
			$Content.RichLinks
		</div>

		<% if $getFutureEvents.exclude('Recurring', 1) %>
			<div class="Events ptl">
				<% include EventListEvents Events=$FutureEvents %>
			</div>
		<% else %>
			<p class="text-center"><em class"noEventsMsg">No upcoming events</em></p>
		<% end_if %>

		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
