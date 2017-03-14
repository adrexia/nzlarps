<!doctype html>
<!--[if IE 6 ]><html class="no-js ie6 oldie gumby-no-touch" lang="$ContentLocale" id="ie6"><![endif]-->
<!--[if IE 7 ]><html class="no-js ie7 oldie gumby-no-touch" lang="$ContentLocale" id="ie7"><![endif]-->
<!--[if IE 8 ]><html class="no-js ie8 oldie gumby-no-touch" lang="$ContentLocale" id="ie8"><![endif]-->
<!--[if IE 9]><html class="no-js ie9 gumby-no-touch" id="ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="no-js gumby-no-touch" lang="$ContentLocale"><!--<![endif]-->
<head>
	<% base_tag %>
	<%-- $FilterDescription adds additional information from the news and events areas --%>
	<title>
		<% if $Event %>
			$Event.Title
		<% else %>
			$Title <% if FilterDescription %>- $FilterDescription<% end_if %> | $SiteConfig.Title
		<% end_if %>
	</title>

	<meta property="og:type" content="article" />
	<meta property="og:title" content="<% if $Event %>$Event.Title<% else %>$Title | $SiteConfig.Title<% end_if %>" />

	$MetaTags(false)
	<meta name="viewport" id="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=10.0,initial-scale=1.0" />

	<% if $Event %>
		<% include MetaImage Context=$Event %>
	<% else %>
		<% include MetaImage Context=$Top %>
	<% end_if %>

	<% if $Intro %>
	<meta property="og:description" content="<% if $Event.Intro %>$Event.Intro.LimitCharacters(100)<% else %>$Intro.LimitCharacters(100)<% end_if %>" />
	<% end_if %>

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements. It must be included _before_ the body element -->
	<!--[if lt IE 9]>
		<script src="$ThemeDir/js/libs/html5shiv-printshiv.js"></script>
	<![endif]-->
	<!--[if lte IE 7]><script src="lte-ie7.js"></script><![endif]-->

	<% require themedCSS('style') %>
	<% include MetaIcons %>

	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,700,100,300' rel='stylesheet' type='text/css'>
</head>

<body data-spy="scroll" class="$ClassName <% if $Colour %>$Colour<% else %>$Level(1).Colour<% end_if %>">
	<% include FBScript %>
	$BetterNavigator
	<% include SkipLinks %>
	<% include Header %>
	<div class="layout" id="layout">
		$Layout
	</div>

	<script type="text/javascript" src="{$ThemeDir}/js/script.min.js"></script>

	<% if SiteConfig.GACode %>
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', '$SiteConfig.GACode', 'auto');
		  ga('send', 'pageview');
		</script>
	<% end_if %>

	<% if SiteConfig.AddThisProfileID %>
		<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=$SiteConfig.AddThisProfileID"></script>
	<% end_if %>


</body>
</html>
