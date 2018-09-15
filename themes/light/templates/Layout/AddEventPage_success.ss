<div class="row">
	<div class="columns twelve">
		<div class="top-panel" role="main" id="main">
			<div class="main">
				<% if $Success %>
					<% include BackButton %>
					$Success
				<% end_if %>
			</div>
		</div>

		<div class="mtm">
			<div class="main">
				<% if $Success %>
					<% include UserEvents %>
				<% end_if %>
			</div>
		</div>
	</div>
</div>
