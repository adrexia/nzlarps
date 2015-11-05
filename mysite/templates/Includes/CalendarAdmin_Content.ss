<div id="calendaradmin-cms-content" class="cms-content center cms-tabset $BaseCSSClasses" data-layout-type="border" data-pjax-fragment="Content">

	<div class="cms-content-header north">
		<div class="cms-content-header-info">
			<h2>
				<% include CMSSectionIcon %>
				<% if SectionTitle %>
					$SectionTitle:
				<% else %>
				<% end_if %>

								$SubTitle
			</h2>
		</div>
	</div>

	<div class="cms-content-fields center ui-widget-content" data-layout-type="border">
			$Tools

			<% if $Action == 'index' %>
				$ComingEventsForm
			<% end_if %>
			<% if $Action == 'pastevents' %>
				$PastEventsForm
			<% end_if %>
			<% if $Action == 'calendars' %>
				$CalendarsForm
			<% end_if %>
			<% if $Action == 'categories' %>
				$CategoriesForm
			<% end_if %>


	</div>

</div>
