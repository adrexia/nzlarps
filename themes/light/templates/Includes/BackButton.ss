<% if $Parent && $Parent.Parent %>
<a href="$Parent.Link" class="back-link">
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" viewBox="0 0 16 8">
	<path fill="#000000" d="M5.857 10.599l-0.479 0.479-3.079-3.079 3.079-3.079 0.479 0.479-2.26 2.26h10.041v0.678h-10.041z"></path>
	</svg>

	<span class="text">$Parent.Title</span>
</a>
<% end_if %>

<% if $EventListLink %>
<a href="$EventListLink" class="back-link">
	<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="40" height="40" viewBox="0 0 16 8">
	<path fill="#000000" d="M5.857 10.599l-0.479 0.479-3.079-3.079 3.079-3.079 0.479 0.479-2.26 2.26h10.041v0.678h-10.041z"></path>
	</svg>

	<span class="text">Events</span>
</a>
<% end_if %>
