<div class="row">
	<div class="columns twelve">
		<div class="typography top-panel" role="main" id="main">
			<% if $MemberContent %>
				<div class="member">
					<span class="member-meta">nzlarps member content</span>
					$MemberContent
				</div>
			<% end_if %>

			<section class="main">
				$Content.RichLinks

				$Form
				<% include RelatedPages %>
				$PageComments
			</section>
		</div>
	</div>
</div>
