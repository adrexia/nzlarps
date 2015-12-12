<?php
/**
 * Adds new Event fields
 */

class EventExtension extends DataExtension {

	private static $db = array(
		'Intro' => 'Text',
		'Colour' => 'Varchar(255)'
	);

	private static $has_one = array(
		'SplashImage' => 'Image',
		'SmallImage' => 'Image',
		'Region' => 'Region'
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
			'earth'=> ' #79c608',
			'passion'=> '#b02635',
			'people'=> '#de347f',
			'inspiration'=> '#783980'
		);
	}
	public function updateCMSFields(FieldList $fields) {

		$details = $fields->dataFieldByName('Details');
		$event = $fields->dataFieldByName('EventPageID');


		$cID = Calendar::get_one('Calendar')->ID;

		$fields->push($calendar = HiddenField::create('CalendarID', 'Calendar'));

		$calendar->setValue($cID);


		$fields->insertAfter($event, 'TimeFrameType');
		$fields->insertAfter(
			$region = DropdownField::create(
				'RegionID',
				'Region',
				Region::get()->map('ID', 'Title')),
			'EventPageID');


		$region->setEmptyString(' ');

		$fields->removeByName('RelatedPage');

		$fields->addFieldToTab('Root.Details', TextareaField::create('Intro', 'Intro'));

		$fields->insertAfter($details, 'Intro');


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

	public function Level($num) {
		return CalendarPage::get_one('CalendarPage');
	}

}
