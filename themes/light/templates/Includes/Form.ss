<% if $Message %>
	<p id="{$FormName}_error" class="alert $MessageType alert--inpage">
		<span class="entypo icon-attention"></span>
		$Message
	</p>
<% else %>
	<p id="{$FormName}_error" class="alert $MessageType alert--inpage" style="display: none"></p>
<% end_if %>

<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>

			<% if $Legend %><legend>$Legend</legend><% end_if %>
			<fieldset>
			<% loop $Fields %>
				$FieldHolder
			<% end_loop %>
			</fieldset>
		<% if Actions %>
		<div class="Actions">
			<% loop $Actions %>
				$Field
			<% end_loop %>
		</div>
		<% end_if %>
<% if $IncludeFormTag %>
</form>
<% end_if %>
