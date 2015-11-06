<div class="row">
	<div class="columns twelve">
		<div class="top-panel" role="main" id="main">
			$Content.RichLinks.Pagebreaks
			$Form
			<% include RelatedPages %>
			$PageComments
		</div>

		<% if $getFutureEvents %>
			<div class="Events ptl">
				<% include EventListEvents Events=$AllEvents %>
			</div>
		<% else %>
			<p><em class"noEventsMsg">No upcoming events</em></p>
		<% end_if %>

		<% if $ExtraContent %>
		<div class="mtm">
			$ExtraContent.RichLinks.Pagebreaks
		</div>
		<% end_if %>
		<footer class="content-footer columns twelve">
			<% include PrintShare %>
			<% include LastEdited %>
		</footer>
	</div>
</div>
