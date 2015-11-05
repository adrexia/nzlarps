
<% if $Action != "index" %>
	<div style="margin-top: 30px; float: right; position: relative; z-index: 8; margin-right: 15px;">
		<a href="$Link" class="special-button ss-ui-button ss-ui-action-constructive cms-panel-link ui-corner-all">
			Coming Events
		</a>
	</div>
<% end_if %>
<% if $Action != "pastevents" %>
	<div style="margin-top: 30px; float: right; position: relative; z-index: 8; margin-right: 15px;">
		<a href="{$Link}pastevents/" class="special-button ss-ui-button ss-ui-action-constructive cms-panel-link ui-corner-all">
			Past Events
		</a>
	</div>
<% end_if %>
