<?php
class Page extends SiteTree {

	private static $icon = "mysite/images/sitetree_images/page.svg";

	private static $db = array(
		'Intro' => 'Text',
		'Colour' => 'Varchar(255)',
		'ExtraContent' => 'HTMLText',
		'FullPageSplashImage' => 'Boolean',
		'MemberOnlyContent' => 'HTMLText'
    );

	private static $has_one = array(
		'SplashImage' => 'Image'
	);

	private static $has_many = array(
		'FeatureItems' => 'FeatureItem'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$this->getBrandFields($fields);

		if($this->ClassName === "Page" || $this->ClassName === "HomePage") {
			$this->getFeatureFields($fields);
		} else if($this->ClassName === "CalendarPage") {
            $this->getCalendarFields($fields);
		}

        $fields->insertBefore('Metadata', $memberContent = HTMLEditorField::create('MemberOnlyContent', 'Member Only Content'));

		$memberContent->addExtraClass('stacked')
		->setRows(20);

		return $fields;
	}

	public function getBrandFields($fields) {

        $fields->insertBefore(TextareaField::create('Intro', 'Intro'),'Content');

        $fields->insertAfter(
            ColorPaletteField::create(
                "Colour", "Colour",
                array(
                    'night'=> '#333333',
                    'air'=> '#009EE2',
                    'earth'=> ' #2e8c6e',
                    'passion'=> '#b02635',
                    'people'=> '#de347f',
                    'inspiration'=> '#783980'
                )
            ), "Intro"
        );

        $fields->insertAfter($splash = FileAttachmentField::create('SplashImage', 'Splash Image'), 'Colour');

        $splash->setDescription("Format: JPG <br> Files should be under 250kb <br>Approx dimensions: 1200px * 600px")
            ->setFolderName('Uploads/Splash-Images')
            ->setMaxResolution(50000000)
            ->setMaxFiles(1)
            ->setMultiple(false)
            ->setTrackFiles(true);

        if($this->ClassName !== "HomePage") {
            $fields->insertAfter(CheckboxField::create('FullPageSplashImage', 'Match splash image to viewport (fullscreen image)'),'SplashImage');
        }
    }

    /**
     * @param $fields FieldList
     */
	public function getFeatureFields($fields) {
        $fields->insertAfter('Content', HTMLEditorField::create('ExtraContent'));

        $gridField = new GridField(
            'FeatureItems',
            'FeatureItems',
            $this->FeatureItems()->sort(array('Sort'=>'ASC','Archived'=>'ASC')),
            $config = GridFieldConfig_RelationEditor::create()
        );
        $gridField->setModelClass('FeatureItem');
        $config->addComponent(new GridFieldOrderableRows());
        $fields->addFieldToTab('Root.Features', $gridField);
    }

	public function getCalendarFields($fields) {
        $content = $fields->dataFieldByName('Content');
        $content->addExtraClass('no-pagebreak');

        $events = Event::get()->sort(array('StartDateTime'=>'Desc'))->filterByCallback(function($record) {
            return !$record->getIsPastEvent();
        });

        $gridField = new GridField(
            'PublicEvent',
            'Upcoming Events',
            $events,
            $config = GridFieldConfig_RecordEditor::create()
        );
        $gridField->setModelClass('PublicEvent');

        $dataColumns = $config->getComponentByType('GridFieldDataColumns');

        $dataColumns->setDisplayFields(array(
            'Title' => 'Title',
            'StartDateTime' => 'Date and Time',
            'DatesAndTimeframe' => 'Presentation String'
        ));

        $fields->addFieldToTab('Root.UpcomingEvents', $gridField);
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

		Requirements::block(THIRDPARTY_DIR . '/jquery/jquery.js');
		Requirements::block(THIRDPARTY_DIR . '/jquery-ui/jquery-ui.js');
	}


	public function getCurrentSliderItems() {
		return $this->SliderItems()->filter('Archived', false);
	}

	public function getMemberProfilePage() {
		return MemberProfilePage::get()->First();
	}

	public function getMemberContent() {

		if ($this->isMember()) {
			return $this->MemberOnlyContent;
		}

        return false;
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

	public function isMember() {
		$member =  Member::currentUser();

		if (!$member) {
			return false;
		}

		if ($member->MembershipStatus==='Verified' || Permission::check('CMS_ACCESS')) {
			return true;
		}

        return false;
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

	/**
	 * Get the Add Event Page
	 *
	 * @return DataObject | boolean
	 */
	public function getAddEventPage() {
		$result = AddEventPage::get_one('AddEventPage');

		// Remove all entries that can not be viewed by the current user
		if($result && isset($result)) {
			if($result->canView()) {
				return $result;
			}
		}

		return false;
	}

	/**
	 * @return DataObject - CalendarPage
	 */
	public function getCalendarPage() {
		return CalendarPage::get_one('CalendarPage');
	}

	/**
	 * @return bool|String
	 */
	public function getCalLink() {
		$calPage = $this->getCalendarPage();

		if (!$calPage) {
			return false;
		}

		return Controller::join_links($calPage->Link(), 'calendarview');
	}

	public function getMyEventsLink() {
		$addEvent = $this->getAddEventPage();

		if (!$addEvent) {
			return false;
		}

		return Controller::join_links($addEvent->Link(), 'myevents');
	}



	public function getMembersEvents() {
		$events = PublicEvent::get();
		if (!$events) {
			return false;
		}
		return $events->filter('OwnerID', Member::currentUserID())->sort('Created', 'DESC');
	}
	
	public function getSuccess() {
		return $this->failover->Success;
	}
}
