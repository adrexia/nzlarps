<div class="row">
	<div class="columns twelve">
		<div class="top-panel" role="main" id="main">

			<% if $MemberContent %>
				<div class="member">
					<span class="member-meta">nzlarps member content</span>
					$MemberContent
				</div>
			<% end_if %>

			<% if $Success %>
			<div class="main">
				<% include BackButton %>
				$Success
			</div>
			<% end_if %>

		</div>
		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
