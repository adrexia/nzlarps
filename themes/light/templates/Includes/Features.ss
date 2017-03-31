<% if CurrentFeatureItems %>
<div class="row features ">
	<div class="columns twelve">
		<div class="feature-content slides masonry-items js-isotope" id="feature-group">
			<% loop CurrentFeatureItems %>
				<% if $Type =='News' && $NewsPage.NewsItems() %>

					<div class="item $EvenOdd">
						<div class="feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
							<h3>
								<a href="$NewsPage.Link">$Title</a>
							</h3>
							<% include FeatureListing Items=$NewsPage.RecentNews, Type=News %>
						</div>
					</div>

				<% else_if $Type=='Events' && $Events().exclude('Recurring', 1) %>

						<div class="item $EvenOdd">
							<div class="feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
								<h3>
									<a href="$CalendarPage.Link">$Title</a>
								</h3>
								<% include FeatureListing Items=$Events.exclude('Recurring', 1), Type=Events %>
							</div>
						</div>

				<% else_if $Type =='Project' && $Projects() %>

					<div class="item $EvenOdd">
						<div class="feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
							<h3>
								<a href="$Link.Link">
									$Title
								</a>
							</h3>
							<% include FeatureListing Items=$Projects, Type=Projects %>
						</div>
					</div>

				<% else_if $Type == 'HTML' %>
					<div class="item $EvenOdd">
						<div class="feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
							<h3>
								<% if $Title %>$Title<% end_if %>
								<% if $SubTitle %><span class="subhead meta-data">$SubTitle</span><% end_if %>
							</h3>
							<% if $HTML %>
							<article class="text">
								$HTML
							</article>
							<% end_if %>

							<% if $Image %>
								<div class="img-wrap">$Image.SetWidth(430)</div>
							<% end_if %>

						</div>
					</div>

				<% else_if $Type == Content %>
				<div class="item $EvenOdd">

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
							<div class="img-wrap">$Image.SetWidth(430)</div>
						<% end_if %>

					<% if $Link %></a><% else %></div><% end_if %>
				</div>
				<% end_if %>
			<% end_loop %>
		</div>
	</div>
</div>
<% end_if %>
