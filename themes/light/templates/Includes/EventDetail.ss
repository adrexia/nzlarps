<div class="row">
	<div class="columns twelve">
		<div class="main typography first" role="main" id="main">
			<div class="EventDetail">
				<% with Event %>
					<h2>
						<% if $Region %>
							$Region.Title,
						<% end_if %>
						$StartDateTime.DayOfMonth
						$StartDateTime.Format('F, Y')
					</h2>
					<p class="subhead">
						<% if $StartAndEndDates %>
							<span>$StartAndEndDates</span>
						<% else %>
							<% if $AllDay %>
								<span>All Day</span>
							<% else %>
								<span>$FormattedTimeframe</span>
							<% end_if %>
						<% end_if %>

					</p>

					$Details

					<% if $EventPage %>
						<% with $EventPage %>
							<a href="$Link" class="btn medium oval default"><span>More $Title</span></a>
						<% end_with %>
					<% end_if %>
				<% end_with %>
			</div>

		</div>

		<% if $Event.ExtraContent %>
			<div class="main mtm">
				$Event.ExtraContent.RichLinks
			</div>
		<% end_if %>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
