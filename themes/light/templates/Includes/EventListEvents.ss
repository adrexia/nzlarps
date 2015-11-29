<div class="row features">
	<div class="columns twelve">
		<div class="feature-content slides masonry-items js-isotope" id="feature-group">
			<% loop $Events %>

			<div class="item <% if $getIsPastEvent() %>past<% end_if %>">

				<a href="$InternalLink" class="link feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">

					<% if $Region %>
						<span class="region label $Region.Colour">$Region.Title</span>
					<% end_if %>

					<h3>
						<span class="subhead meta-data">
							<% if $StartAndEndDates %>
								$StartAndEndDates
							<% else %>
								<% if $StartDateTime %>
									$StartDateTime.Format('d M Y')
								<% end_if %>
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
							<% if not $Short %>
								<p>$Intro</p>
							<% end_if %>
							<br/>
							<span class="btn oval default medium">
								<span>Read More</span>
							</span>
						</article>


					<% if $SmallImage %>
						<div class="img-wrap">$SmallImage.SetWidth(430)</div>
					<% end_if %>
				</a>
			</div>
			<% end_loop %>
		</div>
	</div>
</div>
