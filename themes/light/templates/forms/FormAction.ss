<% if UseButtonTag %>
	<button $AttributesHTML>
		<% if ButtonContent %>$ButtonContent<% else %>$Title<% end_if %>
	</button>
<% else %>
	<div class="btn default large">
		<input $AttributesHTML>
	</div>
<% end_if %>
