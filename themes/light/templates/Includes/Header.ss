<div class="splash-overlay<% if $ClassName == 'HomePage' %> fullheight<% else_if $FullPageSplashImage %> fullheight withnav<% else %> cropped<% end_if %> <% if $Event && $Event.Colour %>$Event.Colour<% else %><% if $Colour %>$Colour<% else %>$Level(1).Colour<% end_if %><% end_if %>">
	<% include Navbar %>

	<div class="splash" style="background-image: url('<% if $Event && $Event.SplashImage %>$Event.SplashImage.URL<% else %><% if $SplashImage %>$SplashImage.URL<% else %>$Level(1).SplashImage.URL<% end_if %><% end_if %>');"></div>
	<div class="overlay"></div>

	<header class="page-header">
		<div class="row">
			<div class="centered eight columns" id="main">

				<% if $Event %>
					<% include Title Title=$Event.Title %>
					<% if $Event.Intro %>
					<p class="lead pbl">
						$Event.Intro
					</p>
					<% end_if %>
				<% else %>
					<% include Title Title=$Title %>
					<% if $Intro %>
					<p class="lead <% if not $JoinLink.LinkURL %>pbl<% end_if %>">
						$Intro
					</p>
					<% end_if %>
				<% end_if %>

				<% if $JoinLink.LinkURL %>
					<span class="btn large">
						<a href="$JoinLink.LinkURL"><% if $isMember %>Your Membership<% else %>Join Now!<% end_if %></a>
					</span>
				<% end_if %>
			</div>


		</div>
		<% if $ClassName=='HomePage' %><% else %>
			<% include SecondaryMenu %>
		<% end_if %>

	</header>
</div>
