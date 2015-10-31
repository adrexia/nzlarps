<% loop $Items.Limit($NumberToDisplay) %>

	<div class="listing-item $FirstLast">
		<% if $Image %>
			<div class="img-wrap">
				$Image.SetHeight(100)
			</div>
		<% end_if %>
		<div class="text-block">
			<h4>$Title</h4>
			<% if Type == News %>
				<% if $Author %>
				<p class="metadata">
					<span class="author">by $Author</span>
				</p>
				<% end_if %>
			<% else_if Type == Event %>
				<p class="metadata">
					<% if $StartDate %>
						<span class="date">$StartDate.format(j F Y)</span>
					<% end_if %>
					<span class="location">$Location</span>
				</p>
			<% else %>
				<p>$Abstract</p>
			<% end_if %>
		</div>
	</div>
<% end_loop %>
