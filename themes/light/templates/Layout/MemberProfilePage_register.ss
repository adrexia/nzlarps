<div class="row">
	<div class="columns twelve">
		<div class="main typography top-panel" role="main" id="main">
			$Content.RichLinks

			<% if $MemberContent %>
				$MemberContent
			<% end_if %>

			$Form
			<% include RelatedPages %>
			$PageComments
		</div>
	</div>
</div>
