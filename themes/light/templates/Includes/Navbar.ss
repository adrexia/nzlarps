<nav id="navbar" class="navbar" role="navigation">
	<div class="row">
		<h2 class="nonvisual-indicator">Main navigation</h2>
		<ul class="columns twelve">
			<li class="link logo <% if $URLSegment = home %> active current<% end_if %>">
				<% if SiteConfig.Logo %>
					<a class="<% if $URLSegment = home %>current<% end_if %>" title="Return to homepage" href="$BaseHref">
						<img src="$SiteConfig.Logo.URL" alt="$SiteConfig.Title logo" title="$SiteConfig.Title" />
						<span class="sr-only">$SiteConfig.Title</span>
					</a>
				<% end_if %>
			</li>
			<li class="pull-right link login">
				<% if $CurrentMember %>
					<a href="$MemberProfilePage.Link">
						$CurrentMember.FirstName
					</a>
					|
					<a href="{$BaseHref}Security/logout?BackURL={$Link}">Log out</a>
				<% else %>
					<a href="{$BaseHref}Security/login?BackURL={$Link}">Login</a>
				<% end_if %>
			</li>
			<% loop Menu(1) %>
				<li class="nav-$FirstLast $LinkingMode <% if $LinkingMode = current %> active<% end_if %>">
					<a href="$Link" title="$Title.XML" class="$LinkingMode">$MenuTitle.XML</a>
				</li>
			<% end_loop %>
		</ul>
	</div>
</nav>
