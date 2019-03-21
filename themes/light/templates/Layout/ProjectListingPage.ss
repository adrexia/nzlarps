<div class="row">
	<div class="columns twelve">
		<div class="top-panel" role="main" id="main">
			<% include BackButton %>
			$Content.RichLinks.Pagebreaks
			$Form
			<% include RelatedPages %>
			$PageComments
		</div>

		<% if $Projects %>
			<div class="ptl">
				<div class="row features">
					<div class="columns twelve">
						<div class="feature-content slides masonry-items js-isotope" id="feature-group">
							<% loop $Projects %>

							<div class="item <% if $State==Past %>past<% end_if %>">

								<a href="$Link" class="link feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
									<span class="region label night">$State</span>

									<h3>
										<% if $Title %>$Title<% end_if %>
									</h3>

									<article class="text">
										<% if $Intro %>
											<p>$Intro</p>
										<% else_if $Tagline %>
											<p>$Tagline</p>
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

							<% loop $ProjectListings %>

								<div class="item">

									<a href="$Link" class="link feature-block type-{$Type.LowerCase()} $Colour.LowerCase() $FirstLast">
										<h3>
											<% if $Title %>$Title<% end_if %>
										</h3>

										<article class="text">
											<% if $Intro %>
												<p>$Intro</p>
											<% end_if %>
											<br/>
											<span class="btn oval default medium">
											<span>Read More</span>
										</span>
										</article>

										<% if $SplashImage %>
											<div class="img-wrap">$SplashImage.SetWidth(430)</div>
										<% end_if %>
									</a>
								</div>
							<% end_loop %>
						</div>
					</div>
				</div>
			</div>
		<% end_if %>

		<% if $ExtraContent || $MemberContent %>
		<div class="mtm">
			<% if $MemberContent %>
				$MemberContent
			<% end_if %>
			<% if $ExtraContent %>
			$ExtraContent.RichLinks.Pagebreaks
			<% end_if %>
		</div>
		<% end_if %>
		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
