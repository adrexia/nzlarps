<div class="row">
	<div class="columns twelve">
		<div class="main top-panel calendar" role="main" id="main">
			<div class="fullcalendar">

				<% include CalendarPageMenu CurrentMenu='calendarview' %>

				<% include FullcalendarCustomNav CurrentMenu='calendarview' %>

				<div id="calendar"></div>
			</div>
		</div>
		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
