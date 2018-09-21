<ul>
	<% loop $RecentEvents %>
	<li><a class="cms-panel-link" href="$EditLink"><span class="">$Title</span> <span class="panel-date">edited: $LastEdited.format(d M Y)</span></a></li>
	<% end_loop %>
</ul>