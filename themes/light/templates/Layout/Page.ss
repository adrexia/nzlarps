<div class="row">
	<div class="columns twelve">
		<div class="main typography first" role="main" id="main">
			$Content.RichLinks
			$Form
			<% include RelatedPages %>
			$PageComments
		</div>

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
