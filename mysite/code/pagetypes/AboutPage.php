<?php

class AboutPage extends Page {

	private static $icon = "mysite/images/sitetree_images/about.png";
	public $pageIcon = "mysite/images/sitetree_images/about.png";

	private static $db = array(
		'ExtraContent' => 'HTMLText'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter(HTMLEditorField::create('ExtraContent'), 'Content');

		return $fields;
	}

}

class AboutPage_Controller extends Page_Controller {

	private static $allowed_actions = array(
		'region'
	);


	public function region($request) {
		$data = DataObject::get_by_id("Region", $request->param('ID'));
		if(!($data && $data->exists())) {
			return $this->httpError(404);
		}
		return $this->customise($data)->renderWith(array('Region_show', 'Page'));
	}

	/**
	 * Get the {@link FeatureItem} objects attached to this page that are not Archived
	 *
	 * @return ArrayList
	 */
	public function CurrentRegions() {
		return Region::get()->filter('Archived', false)->sort('Sort');
	}


}
