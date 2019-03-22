<div class="row">
	<div class="columns twelve">


		<div class="top-panel" role="main" id="main">
			<% with $Event %>
				<% if $MemberContent %>
					<div class="member">
						<span class="member-meta">nzlarps member content</span>
						$MemberContent
					</div>
				<% end_if %>
			<% end_with %>
			<section class="main">
				<% include BackButton %>

				<div class="EventDetail">
					<% with $Event %>
						<h2>
							<% if $Region %>
								$Region.Title,
							<% end_if %>
							$StartDateTime.DayOfMonth
							$StartDateTime.Format('F, Y')
							<% if $showEditLink() %>
								<br />
								<small class="text-center">
									<a class="btn" href="$getEditLink()">
										Edit
									</a>
								</small>
							<% end_if %>
						</h2>

						<p class="subhead">
							<% if $StartAndEndDates %>
								<span>$StartAndEndDates</span>
							<% else %>
								<% if $AllDay %>
									<span>All Day</span>
								<% else %>
									<span>$FormattedTimeframe</span>
								<% end_if %>
							<% end_if %>
						</p>
						$Details
						<div class="share-wrapper" title="share">
							<share-button></share-button>
						</div>

						<% if $EventPage %>
							<% with $EventPage %>
								<p class="text-center">
									<a href="$Link" class="btn medium oval default"><span>More $Title</span></a>
								</p>
							<% end_with %>
						<% end_if %>
					<% end_with %>
				</div>
			</section>
		</div>
		<footer class="content-footer columns twelve">
			<% include LastEdited %>
		</footer>
	</div>
</div>
