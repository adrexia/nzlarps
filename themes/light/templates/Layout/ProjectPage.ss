<div class="row">
	<div class="columns twelve">
		<div class="top-panel collapse" role="main" id="main">
			<div class="main" role="main" id="main">
				<% include BackButton %>

				<% if $Contact || $Parent.Type || $State || $Tagline || $Website %>
				<h2>
					Details
				</h2>
				<% if $Tagline %><p class="subhead">$Tagline</p><% end_if %>
				<ul>
					<% if $Contact %><li><strong>Contact:</strong> $Contact</li><% end_if %>
					<% if $Parent.Type %><li><strong>Type:</strong> $Parent.Type</li><% end_if %>
					<% if $State %><li><strong>State:</strong> $State</li><% end_if %>
					<% if $Website %><li><strong>Website:</strong> $Website</li><% end_if %>
				</ul>
				<% end_if %>
			</div>
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
			<p class="text-center"><em class"noEventsMsg">No upcoming events</em></p>
		<% end_if %>

		<% if $ExtraContent %>
		<div class="mtm">
			$ExtraContent.RichLinks.Pagebreaks
		</div>
		<% end_if %>
		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
