<div class="row features">
	<div class="columns twelve">
		<div class="feature-content slides masonry-items js-isotope" id="feature-group">
			<% loop $FutureEvents %>

			<div class="item">

				<a href="$InternalLink" class="link feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">

					<% if $Region %>
						<span class="region label $Region.Colour">$Region.Title</span>
					<% end_if %>

					<h3>
						<span class="subhead meta-data">
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

						</span>
						<% if $Title %>$Title<% end_if %>
					</h3>

					<article class="text">
						<p>$Intro</p>
						<br/>
						<span class="btn oval default medium">
							<span>Read More</span>
						</span>
					</article>

					<% if $SmallImage %>
						<div class="img-wrap">$SmallImage.SetWidth(390)</div>
					<% end_if %>
				</a>
			</div>
			<% end_loop %>
		</div>
	</div>
</div>