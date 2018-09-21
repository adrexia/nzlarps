<?php
class HomePage extends Page {

	private static $icon = "mysite/images/sitetree_images/home.svg";
	public $pageIcon = "mysite/images/sitetree_images/home.svg";

	private static $singular_name = 'Home Page';
	private static $description = 'Intended as a primary landing page for the site.';


	private static $has_one = array(
		'JoinLink' => 'Link'
	);


	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertBefore(LinkField::create('JoinLinkID', 'JoinLink'), 'Content');

		$fields->removeByName('Content');
		$fields->removeByName('ExtraContent');

		return $fields;
	}

}

class HomePage_Controller extends Page_Controller {


}
