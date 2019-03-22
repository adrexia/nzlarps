<div class="row">
	<div class="columns twelve"  role="main" id="main">
		<div class="top-panel">
			<% include BackButton %>
			<% if $MemberContent %>
				<div class="member">
					<span class="member-meta">nzlarps member content</span>
					$MemberContent
				</div>
			<% end_if %>
			$Content.RichLinks.Pagebreaks

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

		<% if $ExtraContent %>
		<div class="mtm">
			$ExtraContent.RichLinks.Pagebreaks
		</div>
		<% end_if %>


		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
