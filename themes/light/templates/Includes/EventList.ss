<div class="row">
	<div class="columns twelve">
		<div class="main typography first calendar" role="main" id="main">
			<div class="contentwrap">
				$Content.RichLinks
			</div>

			<% if $Action == 'eventregistration' %>
				<% include CalendarPageMenu CurrentMenu='eventregistration' %>
			<% else %>
				<% include CalendarPageMenu CurrentMenu='eventlist' %>
			<% end_if %>

			<% include FullcalendarCustomNav CurrentMenu='eventlist' %>

			<div class="EventList">

				<% if $Events %>
					<div class="Events">
						<% include EventListEvents %>
					</div>
				<% else %>
					<p><em class"noEventsMsg">No events in this period</em></p>
				<% end_if %>

			</div>
		</div>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
