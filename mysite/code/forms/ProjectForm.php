<?php
/**
 *  Project Form
 *
 */
class ProjectForm extends Form {


	/**
	 * Contructor
	 * @param type $controller
	 * @param type $name
	 */
	function __construct($controller, $name) {
		$fields = $this->getFields();

		 //Actions
		$actions = FieldList::create(
			FormAction::create("doAdd")->setTitle("Submit")->addExtraClass("pull-right btn-primary btn-small")
		);

		$validator = RequiredFields::create(['Title']);
		$this->addExtraClass('ProjectForm');
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

		// Overview fields
		$fields = CompositeField::create(
			TextField::create('Title')->setAttribute('placeholder','Enter a title'),
			TextField::create('Contact'),
			$detailsEditor = CompositeField::create(
				LabelField::create('ContentLabel', 'Details'),
				LiteralField::create('ContentNotes', '<p class="field-notes field-notes--textarea">Note: you can select text to apply formatting and insert links</p>'),

				$html = HTMLEditorField::create('Content', ''),
				LiteralField::create('editorDiv', '<div class="editable"></div>')
			),
			TextField::create('Intro')->setRightTitle('Short intro to show in the page header, and larger listings'),
			TextField::create('Tagline')->setRightTitle('Short tagline, or subheading to show in smaller listings')
	);
		$html->addExtraClass('hide');
		$detailsEditor->addExtraClass('field');

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
				$smallEvent = AjaxSelect2Field::create('SmallImageEventID', '<strong>OR</strong> use the promo image from an event')
			),
			$splashGroup = CompositeField::create(
				$spLabel = LabelField::create('SplashImageLabel', "Splash Image (optional)"),
				LiteralField::create('SplashImageNotes', $spashImageNotes),
				$splash = FileAttachmentField::create('SplashImage', ''),
				$splashEvent = AjaxSelect2Field::create('SplashImageEventID', '<strong>OR</strong> use the splash image from an event')
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

		$fields->push($details = $this->getDetailFields());
		$fields->push($brand = $this->getBrandFields());

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
		$control = $this->getController();
		$project = ProjectPage::get()->byID($control->failover->ID);

		if (!$project) {
			$form->sessionMessage('Technical error: writing project failed. Please try again later, or contact an admin for assistance', 'bad');
			$control->redirectBack();
		}

		$form->saveInto($project);

		if($smid = $data['SmallImageEventID']) {
			$smImageID = $this->getImageFromEvent($smid);

			if ($smImageID) {
				$project->SmallImageID = $smImageID;
			}
		}

		if($spid = $data['SplashImageEventID']) {
			$spImageID = $this->getImageFromEvent($spid, true);

			if ($spImageID) {
				$project->SplashImageID = $spImageID;
			}
		}

		try {
			$project->write();
            $project->writeToStage('Stage');
            $project->writeToStage('Live');
        } catch(Exception $e){
			$form->sessionMessage('Technical error: writing project failed. Please try again later, or contact an admin for assistance', 'bad');
			$control->redirectBack();
			return;
		}

		$control->redirect(Controller::join_links($control->Link(), 'success'));
	}
}
