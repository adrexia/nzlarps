<?php
/**
 * Adds new Event fields
 */

class EventExtension extends DataExtension {

	private static $db = array(
		'Intro' => 'Text',
		'Colour' => 'Varchar(255)',
		'Recurring' => 'Boolean'
	);

	private static $has_one = array(
		'SplashImage' => 'Image',
		'SmallImage' => 'Image',
		'Region' => 'Region',
		'Owner' => 'Member'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $summary_fields = array(
		'Intro',
		'Region.Title',
	);

	public function getPalette() {
		return array(
			'night'=> '#333333',
			'air'=> '#009EE2',
			'earth'=> ' #2e8c6e',
			'passion'=> '#b02635',
			'people'=> '#de347f',
			'inspiration'=> '#783980'
		);
	}

	public function populateDefaults()
	{
		$this->owner->Details = $this->owner->renderWith('EventDefaultContent');
	}

	public function updateCMSFields(FieldList $fields) {

		$fields->removeByName('Details');
		$fields->removeByName('GameDetails');

		$event = $fields->dataFieldByName('EventPageID');
		$fields->addFieldToTab('Root.Details', TextareaField::create('Intro', 'Intro'), 'AllDay');

		$cID = Calendar::get_one('Calendar')->ID;
		$fields->push($calendar = HiddenField::create('CalendarID', 'Calendar'));
		$calendar->setValue($cID);

		$fields->insertAfter($event, 'TimeFrameType');
		$fields->insertAfter($owner = DropdownField::create('OwnerID',
			'Owner',
			Member::get()->sort(['FirstName'=>'ASC', 'Surname'=>'ASC'])->map('ID','Name' )),
			'EventPageID');

		$owner->setEmptyString(' ');

		$fields->insertAfter(
			$region = DropdownField::create(
				'RegionID',
				'Region',
				Region::get()->map('ID', 'Title')),
			'EventPageID');

		$region->setEmptyString(' ');
		$fields->removeByName('RelatedPage');
		$fields->addFieldToTab('Root.Details', TextareaField::create('Intro', 'Intro'));

		$fields->insertBefore(HTMLEditorField::create('Details', ''), 'Intro');

		$fields->insertBefore($recurring = CheckboxField::create('Recurring'), 'EventPageID');
		$recurring->setDescription("Note: this will not automatically create events, but allows for recurring events to stay in the calender and out of the listings");

		$fields->addFieldToTab(
			'Root.Brand',
			ColorPaletteField::create(
				"Colour", "Colour",
				$this->owner->getPalette()
		));

		$fields->insertAfter($splash = UploadField::create('SplashImage', 'Splash Image'),'Colour');
		$fields->insertAfter($small = UploadField::create('SmallImage', 'Small Image'),'SplashImage');

		$splash->setFolderName('Uploads/Splash-Images');
		$small->setFolderName('Uploads/Small-Images');

	}

	public function getColourValue() {
		$colours = $this->owner->getPalette();

		if ($this->owner->Colour) {
			return $colours[$this->owner->Colour];
		} else if($this->owner->Region()) {
			return $colours[$this->owner->Region()->getColourName()];
		}

		return $colours['air'];
	}

	public function showEditLink() {
		$member = Member::currentUser();

		if(!$member || AddEventPage::get()->Count() < 1){
			return false;
		}

		return $this->owner->OwnerID === $member->ID;
	}

	public function getEditLink() {
		$add = AddEventPage::get()->First();

		if (!$add) {
			return false;
		}

		return Controller::join_links($add->AbsoluteLink(), 'edit', $this->owner->ID);
	}


	public function getDeleteLink() {
		$add = AddEventPage::get()->First();

		if (!$add) {
			return false;
		}

		return Controller::join_links($add->AbsoluteLink(), 'delete', $this->owner->ID);
	}

	/**
	 * Getter for internal event link
	 * NOTE: The current implementation only works properly as long as there's only one
	 * {@see CalendarPage} in the site
	 */
	public function Link() {
		$calendarPage = CalendarPage::get()->First();

		if (!$calendarPage) {
			return false;
		}

		return Controller::join_links($calendarPage->Link(), 'detail', $this->owner->ID);
	}


	/**
	 * We only want verified members and those with CMS access to create events
	 * @param Member|int $member
	 * @return bool True if the current user can edit this object
	 */
	public function canCreate($member = null) {
		$member = $member ? $member :  Member::currentUser();

		if (!$member) {
			return false;
		}

		$result = parent::canCreate($member);

		if ($member->MembershipStatus==='Verified' || Permission::check('EVENT_CREATE')) {
			return true;
		}

		return $result;
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

		if ($member->ID === $this->owner->OwnerID || Permission::check('EVENT_EDIT')) {
			return true;
		}

		return $result;
	}

	/**
	 * We only want owners and those with CMS access to be able to delete events
	 * @param Member|int $member
	 * @return bool True if the current user can edit this object
	 */
	public function canDelete($member = null) {

		$member = $member ? $member :  Member::currentUser();

		if (!$member) {
			return false;
		}

		$result = parent::canDelete($member);

		if ($member->ID === $this->owner->OwnerID || Permission::check('EVENT_DELETE')) {
			return true;
		}

		return $result;
	}

}
