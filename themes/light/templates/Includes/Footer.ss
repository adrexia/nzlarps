<footer class="footer" role="contentinfo">
	<div class="row">
		<div class="columns twelve">


				<ul>
					<% if $SiteConfig.FooterLinks %>
						<% loop $SiteConfig.FooterLinks %>
							<li><a href="$Link">$Title</a></li>
						<% end_loop %>
					<% end_if %>
					<li class="footer-copyright">
						&copy; NZLarps 2018
					</li>
					<li class="footer-social">
						<% if $SiteConfig.FacebookURL || $SiteConfig.TwitterUsername %>

							<% if $SiteConfig.TwitterUsername %>
								<a class="meta-data pull-right" href="http://www.twitter.com/$SiteConfig.TwitterUsername">
									<span class="icon-twitter entypo" aria-hidden="true"></span>
									<span class="sr-only">Follow us on Twitter</span></a>
							<% end_if %>
							<% if $SiteConfig.FacebookURL %>
								<a class="meta-data pull-right" href="http://www.facebook.com/$SiteConfig.FacebookURL">
									<span class="icon-facebook entypo" aria-hidden="true"></span>
									<span class="sr-only">Join us on Facebook</span></a>
							<% end_if %>

						<% end_if %>
					</li>

				</ul>

		</div>
	</div>
</footer>

