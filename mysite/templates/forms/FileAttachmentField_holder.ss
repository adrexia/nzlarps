<div id="$Name" class="field<% if $extraClass %> $extraClass<% end_if %> supported">
	<% if $Title %><label class="left" for="$ID">$Title</label><% end_if %>
	<div class="middleColumn">
	<div id="{$Name}Dropzone" class="dropzone-holder <% if $isCMS %>backend<% end_if %> <% if $CanUpload %>uploadable<% end_if %>" data-config='$ConfigJSON'>
			<ul data-container data-attachments class="file-attachment-field-previews $View">
			<% if $AttachedFiles %>
				<% loop $AttachedFiles %>
					<% include FileAttachmentField_attachments File=$Me, Scope=$Up %>
				<% end_loop %>
			<% end_if %>
		</ul>



		<template>
			$PreviewTemplate
		</template>
		<div class="attached-file-inputs" data-input-name="$InputName">
			<% if $AttachedFiles %>
				<% loop $AttachedFiles %>
				<input class="input-attached-file" type="hidden" name="$Up.InputName" value="$ID">
				<% end_loop %>
			<% end_if %>
		</div>
		<div class="attached-file-deletions" data-input-name="$InputName"></div>

		<p <% if $AttachedFiles %>class="hasfiles"<% end_if %>>
			<% if $IsMultiple && $CanUpload %>
				<strong>Drop files to attach</strong>
			<% else_if $CanUpload %>
				<strong>Drop a file to <% if $AttachedFiles %>update this attachment<% else %>attach<% end_if %></strong>
			<% end_if %>

			<% if $CanUpload && $CanAttach %><br><% end_if %>
			<% if $CanUpload || $CanAttach %>
				<% if $CanUpload %><%t Dropzone.YOUCANALSO "You can also" %> <% end_if %>
				<% if $CanUpload %>
					<a class="dropzone-select">
						<span class="ui-button-text"><%t Dropzone.BROWSEYOURCOMPUTER "browse your computer" %></span>
					</a>
				<% end_if %>
				<% if $CanUpload && $CanAttach %> <%t Dropzone.OR " or " %> <% end_if %>
				<% if $CanAttach %>
					<a class="dropzone-select-existing">
						<%t Dropzone.CHOOSEEXISTING "choose from existing files" %>
					</a>
				<% end_if %>
			<% end_if %>
			<% if $Description %>
				<span class="description">$Description</span>
			<% end_if %>

		</p>


		<% if not $AutoProcess %>
			<button class="process" data-auto-process><%t Dropzone.UPLOADFILES "Upload file(s)" %></button>
		<% end_if %>

	</div>

	<% if $RighTitle %>
		<span class="description">$RighTitle</span>
	<% end_if %>

	<div class="unsupported">
		<p><strong><%t Dropzone.NOTSUPPORTED "Your browser does not support HTML5 uploads. Please update to a newer version." %></strong></p>
	</div>

</div>
</div>
