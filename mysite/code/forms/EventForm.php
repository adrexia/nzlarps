<?php
/**
 * Add Event Form
 *
 */
class EventForm extends Form {


	/**
	 * Contructor
	 * @param type $controller
	 * @param type $name
	 */
	function __construct($controller, $name) {
		$fields = $this->getFields();

		//Actions
		$actions = FieldList::create(
			FormAction::create("doAdd")->setTitle("Submit Event")->addExtraClass("pull-right btn-primary btn-small")
		);

		$validator = RequiredFields::create(array('Title', 'StartDateTime', 'EndDateTime'));
		$this->addExtraClass('PublicEventForm');
		$this->addExtraClass($name);

		parent::__construct($controller, $name, $fields, $actions, $validator);
	}

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

	public function getDetailFields() {

		$details =  $this->renderWith('EventDefaultContent');

		// Overview fields
		$fields = CompositeField::create(
			TextField::create('Title')->setAttribute('placeholder','Enter a title'),
			$detailsEditor = CompositeField::create(
				$gameDetails = LabelField::create('GameDetails', 'Game Details'),
				LiteralField::create('GameDetailNotes', '<p class="field-notes field-notes--textarea">Note: you can select text to apply formatting and insert links</p>'),

				$html = HTMLEditorField::create('Details', '', $details),
				LiteralField::create('editorDiv', '<div class="editable"></div>')
			),
			TextField::create('Intro')->setRightTitle('Short tagline to show in the page header and in listings'),
			$region = DropdownField::create(
				'RegionID',
				'Region',
				Region::get()->map('ID', 'Title')
			),
			$event = DropdownField::create(
				'EventPageID',
				'Event Series',
				EventPage::get()->map('ID', 'Title')
			)
		);
		$html->addExtraClass('hide');
		$detailsEditor->addExtraClass('field');
		$event->setEmptyString('select (optional)')->setDescription('Existing Project, Affliate or Event Series page (optional)');

		return $fields;
	}

	public function getDateFields() {

		$fields = CompositeField::create(
			LiteralField::create('DateHeading', '<h3>Date and Time</h3>'),
			$startDateTime = DatetimeField::create('StartDateTime', 'Start'),
			$endDateTime = DatetimeField::create('EndDateTime', 'End'),
			$recurring = CheckboxField::create('Recurring'),
			HiddenField::create('TimeFrameType', 'DateTime', 'DateTime')
		);

		$recurring->setDescription("Note: this will not automatically create events. It is used for display purposes.");

		$startDateTime->getDateField()
			->setConfig('showcalendar', 1)
			->setConfig('min', date('Y-m-d'))
			->setAttribute('placeholder','Date')
			->setAttribute('required','required')
			->setAttribute('readonly', 'true'); //we only want input through the datepicker

		$startDateTime->getTimeField()
			->setAttribute('placeholder','Time e.g 13:00, or 1pm');

		$endDateTime->getDateField()
			->setConfig('showcalendar', 1)
			->setConfig('min', date('Y-m-d'))
			->setAttribute('placeholder','Date')
			->setAttribute('required','required')
			->setAttribute('readonly', 'true'); //we only want input through the datepicker

		$endDateTime->getTimeField()
			->setAttribute('placeholder','Time e.g 13:00, or 1pm');

		return $fields;
	}

	public function getBrandFields() {

		$spashImageNotes = $this->renderWith('SplashImageNotes');
		$smallImageNotes = $this->renderWith('SmallImageNotes');

		// Overview fields
		$fields = CompositeField::create(
			LiteralField::create('BrandHeading', '<h3>Branding</h3>'),
			ColorPaletteField::create(
				"Colour", "Colour",
				$this->getPalette()),

			$promoGroup = CompositeField::create(
				$smLabel = LabelField::create('SmallImageLabel', "Promo Image"),
				LiteralField::create('SmallImageNotes', $smallImageNotes),
				$small = FileAttachmentField::create('SmallImage', ''),
				$smallEvent = AjaxSelect2Field::create('SmallImageEventID', '<strong>OR</strong> use the promo image from an existing event')
			),
			$splashGroup = CompositeField::create(
				$spLabel = LabelField::create('SplashImageLabel', "Splash Image (optional)"),
				LiteralField::create('SplashImageNotes', $spashImageNotes),
				$splash = FileAttachmentField::create('SplashImage', ''),
				$splashEvent = AjaxSelect2Field::create('SplashImageEventID', '<strong>OR</strong> use the splash image from an existing event')
			)
		);

		$promoGroup->addExtraClass('image-group');
		$splashGroup->addExtraClass('image-group');

		$smallEvent->setConfig('classToSearch', 'PublicEvent');
		$smallEvent->setConfig('filter', ['SmallImageID:not' => 0]);
		$smallEvent->setConfig('resultsFormat', $this->renderWith('Select2SmallImageResult'));
		$smallEvent->addExtraClass('image-dropdown');

		$splashEvent->setConfig('classToSearch', 'PublicEvent');
		$splashEvent->setConfig('filter', ['SplashImageID:not' => 0]);
		$splashEvent->setConfig('resultsFormat', $this->renderWith('Select2SplashImageResult'));
        $splashEvent->addExtraClass('image-dropdown');

		$smLabel->addExtraClass('sr-only');
		$spLabel->addExtraClass('sr-only');

		$splash->setAcceptedFiles(['.jpg, .jpeg'])
			->setDescription("Format: JPG <br> File size limit: 250kb <br>Approx dimensions: 1200px * 600px")
			->setFolderName('Uploads/Splash-Images')
			->setMaxFilesize(0.25)
			->setMaxResolution(50000000)
			->setMaxFiles(1)
			->setMultiple(false)
			->setTrackFiles(true);

		$small->setAcceptedFiles(['.jpg, .jpeg, .png'])
			->setDescription("Format: JPG or PNG <br> File size limit: 100kb. <br>Approx dimensions: 400px * 225px")
			->setFolderName('Uploads/Small-Images')
			->setMaxFilesize(0.1)
			->setMaxResolution(10000000)
			->setMaxFiles(1)
			->setMultiple(false)
			->setTrackFiles(true);

		try {
			$splash->setView('grid');
			$small->setView('grid');
		} catch(Exception $e) {}


		return $fields;
	}

	public function getFields() {
		$fields = FieldList::create();

		$cID = Calendar::get_one('Calendar')->ID;
		$fields->push($calendar = HiddenField::create('CalendarID', 'CalendarID', $cID));
		$calendar->setValue($cID);

		$member = Member::currentUserID();
		$fields->push($member = HiddenField::create('OwnerID', 'OwnerID', $member));

		$fields->push($member = HiddenField::create('ID', 'ID'));

		$fields->push($details = $this->getDetailFields());
		$fields->push($time = $this->getDateFields());
		$fields->push($brand = $this->getBrandFields());

		$time->setTag('fieldset');
		$details->setTag('fieldset');
		$brand->setTag('fieldset');

		return $fields;
	}

	public function getImageFromEvent($id, $large = false) {
		$event = PublicEvent::get()->byID($id);

		if(!$event) {
			return false;
		}

		$image = $large ? $event->SplashImage() : $event->SmallImage();

		if ($image->exists()){
			return $image->ID;
		}

		return false;
	}

	/**
	 * Add new event
	 * @param $data
	 * @param $form
	 */
	public function doAdd($data, $form) {
		$memberID = Member::currentUserID();
		$control = $this->getController();
		$event = false;

		// check that the hidden fields are what they should be
		if ((int)$data['OwnerID'] !== $memberID) {
			$form->sessionMessage('User has changed, please try again.', 'bad');
			$control->redirectBack();
			return;
		}

		if($data['ID']) {
			$event = PublicEvent::get()->byID($data['ID']);
		}

		if (!$event) {
			$event = new PublicEvent();
		}

		$form->saveInto($event);

		if($smid = $data['SmallImageEventID']) {
			$smImageID = $this->getImageFromEvent($smid);

			if ($smImageID) {
				$event->SmallImageID = $smImageID;
			}
		}

		if($spid = $data['SplashImageEventID']) {
			$spImageID = $this->getImageFromEvent($spid, true);

			if ($spImageID) {
				$event->SplashImageID = $spImageID;
			}
		}

		try {
			$event->write();
		} catch(Exception $e){
			$form->sessionMessage('Technical error: writing event failed. Please try again later, or contact an admin for assistance', 'bad');
			$control->redirectBack();
			return;
		}

		$control->redirect(Controller::join_links($control->Link(), 'success'));
	}
}
