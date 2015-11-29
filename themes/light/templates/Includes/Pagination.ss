<% if MoreThanOnePage %>
	<div class="pagination-wrap endless-scroll clear">

	<ul id="PageNumbers" class="pagination endless pagination-nav" $PaginationMetadata(2)>
	<% if FirstPage %>
		<li class="prev disabled"><a class="prev paginate-left disabled">&laquo;</a></li>
	<% else %>
		<li class="prev"><a class="prev paginate-left" href="$PrevLink">&laquo;</a></li>
	<% end_if %>

	<% loop Pages %>
		<% if CurrentBool %>
			<li class="active">
				<a href="$Link" class="disabled">$PageNum</a>
			</li>
		<% else %>
			<% if $Link %>
				<li><a class="<% if BeforeCurrent %>paginate-left<% else %>paginate-right<% end_if %>" href="$Link">$PageNum</a></li>
			<% else %>
				<li class="disabled"><a class="disabled">...</a></li>
			<% end_if %>
		<% end_if %>
	<% end_loop %>
	<% if LastPage %>
		<li class="next disabled"><a class="next paginate-right disabled">&raquo;</a></li>
	<% else %>
		<li class="next"><a class="next paginate-right" href="$NextLink">&raquo;</a></li>
	<% end_if %>
	</ul>
	</div>
<% end_if %>
