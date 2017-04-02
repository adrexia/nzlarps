<?php
/**
 * Add Event Form
 *
 */
class AddEventForm extends Form {


	/**
	 * Contructor
	 * @param type $controller
	 * @param type $name
	 */
	function __construct($controller, $name) {
		//Event form specific js/css
		//Timepicker
		Requirements::css('calendar/thirdparty/timepicker/jquery.timepicker.css');

		//Fields
		$fields = $this->getFields();

		//Actions
		$actions = FieldList::create(
			FormAction::create("doAdd")->setTitle("Submit Event")->addExtraClass("pull-right btn-primary btn-small")
		);

		//Validator
		$validator = RequiredFields::create(array('Title'));
		$this->addExtraClass('PublicEventForm');
		$this->addExtraClass($name);
		$this->setAttribute('data-parsley-validate', true);

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
		// Overview fields
		$fields = CompositeField::create(
			LiteralField::create('DetailsHeading', '<h3>Event Details</h3>'),
			TextField::create('Title')->setAttribute('placeholder','Enter a title'),
			TextareaField::create('Intro')->setRows(1),
			$detailsEditor = CompositeField::create(
				new LabelField('GameDetails', 'Game Details'),
				$html = new HTMLEditorField('Details'),
				new LiteralField('editorDiv', '<div class="editable"></div>')
			),
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
			->setAttribute('placeholder','Date')
			->setAttribute('readonly', 'true'); //we only want input through the datepicker

		$startDateTime->getTimeField()
			->setConfig('datavalueformat', 'yyyy-MM-dd HH:mm') //24h format

			->setAttribute('placeholder','Time e.g 13:00, or 1pm');

		$endDateTime->getDateField()
			->setConfig('showcalendar', 1)
			->setAttribute('placeholder','Date')
			->setAttribute('readonly', 'true'); //we only want input through the datepicker

		$endDateTime->getTimeField()
			// ->setConfig('timeformat', 'HH:mm') //24h fromat
			->setAttribute('placeholder','Time e.g 13:00, or 1pm');


		return $fields;
	}



	public function getBrandFields() {
		// Overview fields
		$fields = CompositeField::create(
			LiteralField::create('BrandHeading', '<h3>Branding</h3>'),
			ColorPaletteField::create(
				"Colour", "Colour",
				$this->getPalette()),
			$splashGroup = CompositeField::create(
				LabelField::create('SplashImageLabel', "Splash Image (optional)"),
				LiteralField::create('SplashImageNotes', "<p class='field-notes'>This image should contain no text. This is a set-dressing image, so use something that corresponds to the feel or the theme of the game (not your promo banner). Photos of people can work, but composition is important: the text on top of the image needs to be easily readable</p>"),
				$splash = FileAttachmentField::create('SplashImage', '')
			),
			$promoGroup = CompositeField::create(
				LabelField::create('SmallImageLabel', "Promo Image"),
				LiteralField::create('SmallImageNotes', "<p class='field-notes'>This should be landscape (if its a logo, and naturally square, add padding to both sides to make it landscape). This is where you can use your promotional banners - it will be used on your event promo tile across the website</p>"),
				$small = FileAttachmentField::create('SmallImage', '')
			)
		);

		$splash->setAcceptedFiles(array('.jpg, .jpeg'));
		$splash->setDescription("Format: JPG <br> File size limit: 250kb <br>Approx dimensions: 1200px * 600px");
		$splash->setFolderName('Uploads/Splash-Images');

		$small->setAcceptedFiles(array('.jpg, .jpeg, .png'));
		$small->setDescription("Format: JPG or PNG <br> File size limit: 100kb. <br>Approx dimensions: 400px * 225px");
		$small->setFolderName('Uploads/Small-Images');

		return $fields;
	}


	public function getFields() {
		$fields = FieldList::create();

		$cID = Calendar::get_one('Calendar')->ID;
		$fields->push($calendar = HiddenField::create('CalendarID', 'Calendar'));
		$calendar->setValue($cID);

		$fields->push($details = $this->getDetailFields());
		$fields->push($time = $this->getDateFields());
		$fields->push($brand = $this->getBrandFields());

		$time->setTag('fieldset');
		$details->setTag('fieldset');
		$brand->setTag('fieldset');

		return $fields;
	}



	/**
	 * Add action
	 * @param type $data
	 * @param type $form
	 */
	public function doAdd($data, $form) {
		$e = new PublicEvent();
		$form->saveInto($e);
		$e->write();

		$c = $this->Controller();
		$c->redirect($c->Link() . "success");
	}
}
