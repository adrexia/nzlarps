<div class="splash-overlay<% if $ClassName == 'HomePage' %> fullheight<% else %> cropped<% end_if %> <% if $UseDarkLogo() %>dark<% end_if %> <% if $Colour %>$Colour<% else %>$Level(1).Colour<% end_if %>">
	<% include Navbar %>

	<div class="splash" style="background-image: url('<% if $SplashImage %>$SplashImage.URL<% else %>$Level(1).SplashImage.URL<% end_if %>');"></div>
	<div class="overlay"></div>

	<header class="page-header">
		<div class="row">
			<div class="centered eight columns" id="main">
				<h1 class="">$Title</h1>

				<% if $Intro %>
				<p class="lead <% if not $JoinLink.LinkURL %>pbl<% end_if %>">
					$Intro
				</p>
				<% end_if %>

				<% if $JoinLink.LinkURL %>
				<span class="btn large">
					<a href="$JoinLink.LinkURL">Join Now!</a>
				</span>
				<% end_if %>

			</div>


		</div>
		<% include SecondaryMenu %>
	</header>
</div>
