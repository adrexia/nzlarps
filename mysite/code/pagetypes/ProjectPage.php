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
		'Website' => 'Link',
		'SmallImage' => 'Image'
	);

	private static $many_many = [
		'Owners' => 'Member'
	];

	public function getCMSFields() {

		$fields = parent::getCMSFields();

		$fields->removeByName('Features');

		$fields->insertBefore('Intro', DropdownField::create(
			'State',
			'State',
			$this->dbObject('State')->enumValues()
		));

		$fields->insertBefore('Intro', TextField::create('Tagline'));
		$fields->insertBefore('Intro', TextField::create('Contact'));
		$fields->insertBefore('Intro', LinkField::create('WebsiteID', 'Website'));

		$fields->insertAfter('SplashImage', $small = FileAttachmentField::create('SmallImage', 'Small Image'));

		$small->setDescription("Format: JPG or PNG <br> Files should be under 100kb. <br>Approx dimensions: 400px * 225px")
			->setFolderName('Uploads/Small-Images')
			->setMaxResolution(10000000)
			->setMaxFiles(1)
			->setMultiple(false)
			->setTrackFiles(true);

		$fields->insertBefore(
			'Intro',
			ListboxField::create('Owners', singleton('Member')->i18n_plural_name())
				->setMultiple(true)
				->setSource(Member::get()->map('ID', 'Title')->toArray()));

		return $fields;
	}

	public function showEditLink() {
		$member = Member::currentUser();

		if(!$member) {
			return false;
		}

		return $this->Owners()->byID($member->ID);
	}

	public function getEditLink() {
		return Controller::join_links($this->AbsoluteLink(), 'edit');
	}

	/**
	 * We only want owners and those with CMS access to edit
	 * @param Member|int $member
	 * @return bool True if the current user can edit this object
	 */
	public function canEdit($member = null) {
		$member = $member ? $member :  Member::currentUser();

		if (!$member) {
			return false;
		}

		$result = parent::canEdit($member);

		if ($this->Owners()->byID($member->ID)) {
			return true;
		}

		return $result;
	}
}

class ProjectPage_Controller extends EventPage_Controller {

	private static $allowed_actions = array (
		'EditForm' => true,
		'success' => true,
		'edit' => true
	);

	public function AllEvents() {
		$future = $this->ComingEvents();
		$past = $this->PastEvents();

		$array = array_merge($future->toArray(), $past->toArray());

		return ArrayList::create($array);
	}

	public function EditForm() {
		return ProjectForm::create($this, 'EditForm');
	}

	public function success() {
		return $this->customise([
			'GoodMessage' => 'Thanks! Your project has been successfully updated.'
		])->renderWith(['ProjectPage', 'Page']);
	}


	/**
	 * Allow the owners of projects to edit them
	 * If page is reached by non owners, redirect back to the project page
	 * @param $request
	 * @return mixed
	 */
	public function edit() {
		$member = Member::currentUser();

		if(!$member || !$this->Owners()->byID($member->ID)) {
			$this->redirect($this->Link());
			return false;
		}

		$form = $this->EditForm();
		$form->loadDataFrom($this->failover);

		if ($this->ParentID && $this->Parent()->exists()) {
		    $parent = $this->Parent();
            $content = $parent->obj('EditContent') ? $parent->obj('EditContent') : false;
        }

		$data = [
			'Title' => 'Edit: ' . $this->Title,
			'Form' => $form,
			'Content' => $content
		];

		return $this->customise($data)->render();
	}
}
