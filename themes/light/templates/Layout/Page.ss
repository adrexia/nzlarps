<div class="row">
	<div class="columns twelve">
		<div class="top-panel" role="main" id="main">
			$Content.RichLinks.Pagebreaks
			$Form
			<% include RelatedPages %>
			$PageComments
		</div>

		<% if $CurrentFeatureItems %>
			<div class="ptl">
				<% include Features %>
			</div>
		<% else %>

		<% if $ExtraContent %>
		<div class="mtm">
			$ExtraContent.RichLinks.Pagebreaks
		</div>
		<% end_if %>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
