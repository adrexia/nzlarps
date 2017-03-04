<% loop $Items.Limit($NumberToDisplay) %>

	<div class="listing-item $FirstLast">
		<div class="text-block">
			<a class="text" href="<% if $Link %>$Link<% else %>$InternalLink<% end_if %>">
				<h4 class="">

						<% if $Up.Type == "News" || $StartDateTime || $StartAndEndDates %>
						<span class="subhead pb0 meta-data">
							<% if $Up.Type == "News" %>
								<time datetime="$Created">$Created.Format(d M Y)</time>
							<% end_if %>

							<% if $StartDateTime %>
								$StartDateTime.Format('d M Y')
							<% else_if $StartAndEndDates %>
								$StartAndEndDates
							<% end_if %>
						</span>
						<% end_if %>

						<% if $Title %>$Title<% end_if %>

					<% if $Up.Type == "News" || $Tagline || $StartDateTime || $Region %>
						<span class="subhead pts pb0 meta-data">
							<% if $Up.Type == "News" %>
								<span class="prefix">by </span><% if Author %>$Author<% else %>admin<% end_if %>
							<% end_if %>

							<% if $Tagline %>$Tagline<% end_if %>

							<% if $StartDateTime %>
								<% if not $StartAndEndDates %>
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
				<% if $Up.Type == "News" %>
					<p>$Content.LimitCharacters(80)</p>
				<% end_if %>
			</a>
		</div>
	</div>
<% end_loop %>
