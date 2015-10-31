<div class="row">

	<div class="columns twelve">
		<div class="main typography first" role="main" id="main">
			$Content.RichLinks
			$Form
			<% include RelatedPages %>
			$PageComments
		</div>
		<div class="row block-container">
			<% loop CurrentRegions %>
			<div class="block-link">
				<a class="$Colour" href="$Top.Link{$URLSegment}">
					<h3>$Title</h3>
				</a>
			</div>
			<% end_loop %>
		</div>

		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
