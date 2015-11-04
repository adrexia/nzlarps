<div class="row">
	<div class="columns twelve">
		<div class="main typography first" role="main" id="main">
			$Content.RichLinks
			$Form
			<% include RelatedPages %>
			$PageComments
		</div>

		<% if $Projects %>
			<div class="ptl ">
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
										<p>$Intro</p>
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



			</div>
		<% end_if %>

		<% if $ExtraContent %>
		<div class="main mtm">
			$ExtraContent.RichLinks
		</div>
		<% end_if %>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
