<div id="$Name" class="field<% if extraClass %> $extraClass<% end_if %>">
	<label class="checkbox" for="$ID">
		$Field
		$Title
	</label>
	<% if $Description %><p class="field-notes field-notes--checkbox">$Description</p><% end_if %>
	<% if Message %><span class="message $MessageType">$messageBlock</span><% end_if %>
</div>
