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
		'Type' => 'Enum("Project, Affiliate", "Project")',
		'EditContent' => 'HTMLText',
	);

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$fields->insertAfter(HTMLEditorField::create('ExtraContent'), 'Content');

		$fields->insertBefore(DropdownField::create(
			'Type',
			'Type',
			$this->dbObject('Type')->enumValues()
		), 'Intro');

		$fields->addFieldToTab('Root.OtherContent', $edit = HTMLEditorField::create('EditContent', 'Project Edit Content'));

		$edit->setDescription('Displayed on child project pages when project owner is editing');
		$edit->setRows(20);

		return $fields;
	}

}

class ProjectListingPage_Controller extends Page_Controller {

	public function getProjects() {
		$projectpages = ProjectPage::get();
		if(!$projectpages) {
			return false;
		}

		return $projectpages->filter(array('ParentID' => $this->ID))->sort(array('State' => 'Asc','Title' => 'Asc'));
	}

    public function getProjectListings() {
        $projectlisting = ProjectListingPage::get();
        if(!$projectlisting) {
            return false;
        }

        return $projectlisting->filter(array('ParentID' => $this->ID))->sort(array('Title' => 'Asc'));
    }

}
