<% if CurrentFeatureItems %>
<div class="row features ">
	<div class="columns twelve">
		<div class="feature-content slides masonry-items js-isotope" id="feature-group">
			<% loop CurrentFeatureItems %>
				<% if $Type =='News' && $NewsItems() %>

					<div class="item">
						<a href="$ContentSource.Link" class="feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
							<h3>
								<a href="$NewsPage.Link">$Title</a>
							</h3>
							<article class="text">
								<% include FeatureListing Items=$NewsItems, Type=News %>
							</article>
						</a>
					</div>

				<% else_if $Type =='Events' && $Events() %>

						<div class="item">
							<div class="feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
								<h3>
									<a href="$CalendarPage.Link">$Title</a>
								</h3>
								<article class="text">
									<% include FeatureListing Items=$Events, Type=Events %>
								</article>
							</div>
						</div>

				<% else_if $Type == Content %>
				<div class="item">

					<% if $Link %><a href="$Link.Link" class="link<% else %><div class="<% end_if %> feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">

						<h3>
							<% if $Title %>$Title<% end_if %>
						</h3>
						<% if $Content %>
						<article class="text"><p>$Content</p>

							<% if $Link %>
							<br/>
							<span class="btn oval default medium">
								<span><% if $LinkLabel %>$LinkLabel<% else %>Read More<% end_if %></span>
							</span>
							<% end_if %>

						</article>
						<% end_if %>

						<% if $Image %>
							<div class="img-wrap">$Image.SetWidth(390)</div>
						<% end_if %>

					<% if $Link %></a><% else %></div><% end_if %>
				</div>
				<% end_if %>
			<% end_loop %>
		</div>
	</div>
</div>
<% end_if %>
