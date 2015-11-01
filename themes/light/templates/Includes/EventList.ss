<div class="row">
	<div class="columns twelve">
		<div class="main typography first calendar" role="main" id="main">

			<h2>Upcoming Events</h2>
			$Content.RichLinks
		</div>



		<% if $getFutureEvents %>
			<div class="Events ptl">
				<% include EventListEvents %>
			</div>
		<% else %>
			<p><em class"noEventsMsg">No upcoming events</em></p>
		<% end_if %>


		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
