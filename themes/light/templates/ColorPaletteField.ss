<ul id="$ID" class="$extraClass">
	<% loop Options %>
		<li class="$Class">
			<label for="$ID" style="background-color: $Title">
				<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if isChecked %> checked<% end_if %><% if isDisabled %> disabled<% end_if %> />
				<span></span>
			</label>
		</li>
	<% end_loop %>
</ul>
