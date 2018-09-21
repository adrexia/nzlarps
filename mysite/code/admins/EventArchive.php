<?php
/*
 * Admin for regions
 *
 */

class EventArchive extends ModelAdmin {

	private static $managed_models = array('PublicEvent');
	private static $url_segment = 'eventarchive';
	private static $menu_title = 'Events Archive';
    private static $menu_priority = 5;
	private static $menu_icon = "mysite/images/sitetree_images/event-archive.svg";

	public function getEditForm($id = null, $fields = null){
		$form = parent::getEditForm($id, $fields);


		return $form;
	}

}
