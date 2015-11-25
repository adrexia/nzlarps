<?php
/**
 * Project Page
 * A page for NZLarp projects and affliates
 *
 * @subpackage pagetypes
 */
class ProjectPage extends EventPage {

	private static $singular_name = 'Project Page';
	private static $description = 'A page for projects and affliates.';

	private static $icon = "mysite/images/sitetree_images/stack-hearts.png";
	public $pageIcon = "mysite/images/sitetree_images/stack-hearts.png";

	private static $db = array (
		'State' => 'Enum("Current, Past","Current")',
		'Tagline' => 'Varchar(255)',
		'Contact' => 'Varchar(255)'
	);

	private static $has_one = array (
		'Link' => 'Link',
		'SmallImage' => 'Image'
	);

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$fields->removeByName('Features');

		$fields->insertBefore(DropdownField::create(
			'State',
			'State',
			$this->dbObject('State')->enumValues()
		), 'Intro');

		$fields->insertBefore(TextField::create('Tagline'), 'Intro');
		$fields->insertBefore(TextField::create('Contact'), 'Intro');
		$fields->insertBefore(LinkField::create('LinkID'), 'Intro');

		$fields->insertBefore(UploadField::create(
			'SmallImage',
			'Small Image'
		), 'SplashImage');

		return $fields;
	}

}

class ProjectPage_Controller extends EventPage_Controller {

	public function AllEvents() {
		$future = $this->ComingEvents();
		$past = $this->PastEvents();

		$array = array_merge($future->toArray(), $past->toArray());

		return ArrayList::create($array);
	}

}
