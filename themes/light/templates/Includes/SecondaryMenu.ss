<% if $Menu(2) || $ClassName == 'CalendarPage' %>
	<nav class="secondary-menu text-center" id="page-nav" role="navigation">
		<h2 class="nonvisual-indicator">Secondary Navigation</h2>
		<ul class="nav nav-list inline">

			<% if $ClassName == 'CalendarPage' %>
				<li class="eventlist">
					<a href="{$EventListLink}" class="<% if $CurrentMenu == 'eventlist' %>active<% end_if %> btn medium oval"><span>$MenuTitle</span></a>
				</li>
				<li class="calendarview">
					<a href="{$CalendarViewLink}" class="<% if $CurrentMenu == 'eventlist' %><% else %>active<% end_if %> btn medium oval"><span>Calendar View</span></a>
				</li>
			<% else %>

				<% with $Level(1) %>
					<li class="first">
						<a href="$Link" class="<% if $LinkingMode = current %>active<% end_if %> btn medium oval">
							<span>$MenuTitle</span>
						</a>
					</li>
				<% end_with %>

				<% loop Menu(2) %>
					<li class="<% if $Last %> last<% end_if %>">
						<a href="$Link" class="<% if $LinkingMode = current || $LinkingMode = section %>active<% end_if %> btn medium oval">
							<span>$MenuTitle</span>
						</a>
					</li>
				<% end_loop %>

			<% end_if %>
		</ul>
	</nav>
<% end_if %>
