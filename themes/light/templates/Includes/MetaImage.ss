<% with $Context %>

	<% if $SmallImage %>
		<meta property="og:image" content="$SmallImage.AbsoluteURL" />
	<% else_if $SplashImage %>
		<meta property="og:image" content="$SplashImage.AbsoluteURL" />
	<% else %>
		<meta property="og:image" content="$Level(1).SplashImage.AbsoluteURL" />
	<% end_if %>

<% end_with %>
