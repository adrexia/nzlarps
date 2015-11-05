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

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertBefore(TextareaField::create('Intro', 'Intro'),'Content');
		$fields->insertAfter(HTMLEditorField::create('ExtraContent'), 'Content');

		$fields->insertAfter(
			ColorPaletteField::create(
				"Colour", "Colour",
				array(
					'night'=> '#333333',
					'air'=> '#009EE2',
					'earth'=> ' #79c608',
					'passion'=> '#F15051',
					'people'=> '#de347f',
					'inspiration'=> '#783980'
				)
			), "Intro"
		);

		$fields->insertBefore(UploadField::create('SplashImage', 'Splash Image'),'Content');

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
}
