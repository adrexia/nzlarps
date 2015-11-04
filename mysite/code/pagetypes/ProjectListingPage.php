<?php
/**
 * Project Listing Page
 * A page to list NZLarp projects and affliates
 *
 * @subpackage pagetypes
 */
class ProjectListingPage extends Page {

	private static $icon = "mysite/images/sitetree_images/folder-heart.png";
	public $pageIcon = "mysite/images/sitetree_images/folder-heart.png";

	private static $singular_name = 'Project Listing Page';
	private static $description = 'A page to list projects and affliates.';

	private static $db = array (
		'Type' => 'Enum("Project, Affiliate","Project")'
	);

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$fields->insertBefore(DropdownField::create(
			'Type',
			'Type',
			$this->dbObject('Type')->enumValues()
		), 'Intro');

		return $fields;
	}

}

class ProjectListingPage_Controller extends Page_Controller {

	public function getProjects() {
		if(!$this->Type) {
			return false;
		}

		return ProjectPage::get()->filter(array('Type' => $this->Type))->sort(array('State' => 'Asc','Title' => 'Asc'));
	}

}
