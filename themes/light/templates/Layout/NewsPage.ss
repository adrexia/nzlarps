<div class="main-features top-panel">
	<div class="row features">
		<section class="twelve columns">
			<div class="feature-content slides masonry-items js-isotope pagination-content" id="news-group">

				<% loop $News %>
					<article class="item large $EvenOdd $FirstLast">
						<div class="feature-block $Colour.LowerCase()">
							<span class="region label $Colour">
								<span class="prefix">by </span><% if $Author %>$Author<% else %>admin<% end_if %>
							</span>

							<h3 id="ID-{$ID}">
								<span class="subhead meta-data">
									<time datetime="$Created">$Created.Format(d M Y)</time>
								</span>
								<% if $Title %>$Title<% end_if %>

							</h3>
							<div class="text">
								$Content
							</div>
						</div>

					</article>
				<% end_loop %>

			</div>

			<% with $News %>
				<div class="row">
					<% include Pagination %>
				</div>
			<% end_with %>
		</section>
	</div>
</div>
