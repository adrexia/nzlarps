<% loop $Items.Limit($NumberToDisplay) %>

	<div class="listing-item $FirstLast">
		<div class="text-block">

			<h4 class="">
				<a href="<% if $Link %>$Link<% else %>$InternalLink<% end_if %>">
					<% if $Title %>$Title<% end_if %>
				</a>
				<% if $Author || $Tagline || $StartDateTime || $Region %>
					<span class="subhead pts pb0 meta-data">
						<% if $Author %>
							<span class="author">by $Author</span>
						<% end_if %>

						<% if $Tagline %>$Tagline<% end_if %>

						<% if $StartDateTime %>
							$StartDateTime.DayOfMonth
							$StartDateTime.Format('F, Y')

							<% if $StartAndEndDates %>
								$StartAndEndDates
							<% else %>
								<% if $AllDay %>
									All Day
								<% else %>
									$FormattedTimeframe
								<% end_if %>
							<% end_if %>
						<% end_if %>
						<% if $Region %><br />
							<span class="text-uppercase">$Region.Title</span>
						<% end_if %>
					</span>
				<% end_if %>


			</h4>
			<% if $Type == "News" %>
			<p>$Intro.LimitCharacters(140)</p>
			<% end_if %>
		</div>
	</div>
<% end_loop %>
