<?php
/*
 * Admin for regions
 *
 */

class RegionAdmin extends ModelAdmin {

	private static $managed_models = array('Region');
	private static $url_segment = 'regions';
	private static $menu_title = 'Regions';

	private static $menu_icon = "mysite/images/sitetree_images/regions.png";

	public function getEditForm($id = null, $fields = null){
		$form = parent::getEditForm($id, $fields);


		return $form;
	}

}
