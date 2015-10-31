<footer class="footer typography" role="contentinfo">
	<h2 class="nonvisual-indicator">Footer</h2>
	<div class="row">
	<% if SiteConfig.FooterLinks%>
		<ul class="nav nav-pills <% if SiteConfig.FacebookURL || SiteConfig.TwitterUsername %>six<% else %>twelve<% end_if %>  columns">
			<% loop SiteConfig.FooterLinks %>
				<li><a href="$Link">$Name</a></li>
			<% end_loop %>
		</ul>
		<% end_if %>

	<% if SiteConfig.FacebookURL || SiteConfig.TwitterUsername %>
		<div class="social-links six<% if not Footer %> push_six<% end_if %> columns" role="complementary">
			<p>
				<% if SiteConfig.TwitterUsername %>
					<a class="meta-data" href="http://www.twitter.com/$SiteConfig.TwitterUsername"><i class="icon-twitter icon-dark" aria-hidden="true"></i>Follow us on Twitter</a>
				<% end_if %>
				<% if SiteConfig.FacebookURL %>
					<a class="meta-data" href="http://www.facebook.com/$SiteConfig.FacebookURL"><i class="icon-facebook icon-dark" aria-hidden="true"></i>Join us on Facebook</a>
				<% end_if %>
			</p>
		</div>
	<% end_if %>
	</div>
	
	<div class="footer-copyright">
		<p><small>$SiteConfig.Title &copy; $CurrentDatetime.Format(Y)</small></p>
	</div>
</footer>
