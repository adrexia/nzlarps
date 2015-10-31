<div class="row">
	<div class="columns twelve">
		<div class="main typography first" role="main" id="main">
			$Content.RichLinks

			<div class="EventDetail">
				<% with Event %>
					<h2>$Title</h2>
					<div class="datesAndTimeframe subhead">
						<% if $StartAndEndDates %>
							<span>$StartAndEndDates</span>
						<% else %>
							<% if $AllDay %>
								<span>All Day</span>
							<% else %>
								<span>$FormattedTimeframe</span>
							<% end_if %>
						<% end_if %>
					</div>
					<% if $EventPage %>
						<% with $EventPage %>
							<a href="$Link" style="margin: 12px 0 0 19px;display: block;">Go to the $Title page</a>
						<% end_with %>
					<% end_if %>
					$Details
				<% end_with %>
			</div>

		</div>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
