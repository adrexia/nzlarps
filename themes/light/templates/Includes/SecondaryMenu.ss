<% if $Menu(2) || $ClassName == 'CalendarPage' %>
	<nav class="secondary-menu text-center" id="page-nav" role="navigation">
		<h2 class="nonvisual-indicator">Secondary Navigation</h2>
		<ul class="nav nav-list inline">

			<% if $ClassName == 'CalendarPage' || $ClassName == 'AddEventPage' %>

				<% with $getCalendarPage %>
					<li class="eventlist">
						<a href="{$Link}" class="<% if $Top.CurrentMenu == 'eventlist' %>active<% end_if %> btn medium oval oval--left">
							<span class="entypo icon-list"> &nbsp; $MenuTitle</span>
						</a>
						<a href="{$Link}calendarview" class="<% if $Top.CurrentMenu != 'eventlist' && $Top.ClassName == 'CalendarPage' %>active<% end_if %> btn medium oval oval--right">
							<span class="entypo icon-calendar"> &nbsp; Calendar</span>

						</a>
					</li>
				<% end_with %>
				<% if $getAddEventPage %>
					<li class="addevent">
						<a href="{$getAddEventPage.Link}" class="<% if $ClassName == 'AddEventPage' && $Top.CurrentMenu != 'myevents' %>active<% end_if %> btn medium oval"><span>$getAddEventPage.Title</span></a>
						<a href="{$getAddEventPage.Link}/myevents" class="<% if $ClassName == 'AddEventPage' && $Top.CurrentMenu == 'myevents' %>active<% end_if %> btn medium oval"><span>My events</span></a>
					</li>
				<% end_if %>
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
