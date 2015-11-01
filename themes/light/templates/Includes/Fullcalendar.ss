<div class="row">
	<div class="columns twelve">
		<div class="main typography first calendar" role="main" id="main">
			<div class="fullcalendar">

				<% include CalendarPageMenu CurrentMenu='calendarview' %>

				<% include FullcalendarCustomNav CurrentMenu='calendarview' %>

				<div id="calendar"></div>
			</div>
		</div>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
