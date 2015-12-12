<?php
class Page extends SiteTree {

	private static $icon = "mysite/images/sitetree_images/page.png";

	private static $db = array(
		'Intro' => 'Text',
		'Colour' => 'Varchar(255)',
		'ExtraContent' => 'HTMLText'
	);


	private static $has_one = array(
		'SplashImage' => 'Image'
	);

	private static $has_many = array(
		'FeatureItems' => 'FeatureItem'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertBefore(TextareaField::create('Intro', 'Intro'),'Content');


		$fields->insertAfter(
			ColorPaletteField::create(
				"Colour", "Colour",
				array(
					'night'=> '#333333',
					'air'=> '#009EE2',
					'earth'=> ' #79c608',
					'passion'=> '#b02635',
					'people'=> '#de347f',
					'inspiration'=> '#783980'
				)
			), "Intro"
		);

		$fields->insertBefore(UploadField::create('SplashImage', 'Splash Image'),'Content');


		if($this->ClassName === "Page" || $this->ClassName === "HomePage") {

			$fields->insertAfter(HTMLEditorField::create('ExtraContent'), 'Content');

			$gridField = new GridField(
				'FeatureItems',
				'FeatureItems',
				$this->FeatureItems()->sort(array('Sort'=>'ASC','Archived'=>'ASC')),
				$config = GridFieldConfig_RelationEditor::create()
			);
			$gridField->setModelClass('FeatureItem');
			$fields->addFieldToTab('Root.Features', $gridField);

			$config->addComponent(new GridFieldOrderableRows());

		} else if($this->ClassName === "CalendarPage") {
			$content = $fields->dataFieldByName('Content');
			$content->addExtraClass('no-pagebreak');

			$events = Event::get()->sort(array('StartDateTime'=>'Desc'))->filterByCallback(function($record) {
				return !$record->getIsPastEvent();
			});

			$gridField = new GridField(
				'Event',
				'Upcoming Events',
				$events,
				$config = GridFieldConfig_RecordEditor::create()
			);
			$gridField->setModelClass('Event');

			$dataColumns = $config->getComponentByType('GridFieldDataColumns');

			$dataColumns->setDisplayFields(array(
				'Title' => 'Title',
				'StartDateTime' => 'Date and Time',
				'DatesAndTimeframe' => 'Presentation String'
			));


			$fields->addFieldToTab('Root.UpcomingEvents', $gridField);

		}

		return $fields;
	}

	public function getCurrentRegistration(){
		$member = Member::currentUser();
		if(!$member) return false;

		return $member;
	}

}
class Page_Controller extends ContentController {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		Requirements::set_force_js_to_bottom(true);
	}


	public function getCurrentSliderItems() {
		return $this->SliderItems()->filter('Archived', false);
	}

	public function getMemberProfilePage() {
		return MemberProfilePage::get()->First();
	}

	public function HomePage() {
		return HomePage::get_one('HomePage');
	}

	public function LoginLink() {
		return Controller::join_links(
			Injector::inst()->get('Security')->Link(),
			'login',
			'?BackURL=' . urlencode($this->Link())
		);
	}

	public function CMSAccess() {
		return Permission::check('ADMIN') || Permission::check('CMS_ACCESS_LeftAndMain');
	}

	// Strip underscores and spaces from a string
	public function NiceString($title, $sentenceCase = false) {
		$title = str_replace("_",  " ", $title);
		if ($sentenceCase) {
			$title = ucfirst($title);
		}
		return str_replace("-",  " ", $title);
	}

	public function CountCharacters($string) {
		return strlen($string);
	}

	public function UseDarkLogo() {
		return $this->Colour === 'night' || $this->Colour === 'inspiration';
	}

	public function getFutureEvents() {
		return CalendarHelper::coming_events();
	}

	/**
	 * Get the {@link FeatureItem} objects attached to this page
	 *
	 * @return ArrayList
	 */
	public function FeatureItems() {
		return $this->getComponents('FeatureItems')->sort('SortOrder');
	}

	/**
	 * Get the {@link FeatureItem} objects attached to this page that are not Archived
	 *
	 * @return ArrayList
	 */
	public function CurrentFeatureItems() {
		return $this->FeatureItems()->filter('Archived', false)->sort('Sort');
	}
}
