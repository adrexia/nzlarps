<?php
/**
 * Home page feature item- ability to store different data in the same table
 *
 * @category model
 */
class FeatureItem extends DataObject {

	/**
	 * @var array
	 * @static
	 */
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Type' => 'Enum("Content, HTML, Events, News, Project", "Content")',
		'Colour' => 'Varchar(255)',
		'Content' => 'Text',
		'SubTitle' => 'Varchar(255)',
		'HTML' => 'HTMLText',
		'LinkLabel' => 'Varchar(255)',
		'NumberToDisplay' =>'Int',
		'Sort' => 'Int',
		'Archived' => 'Boolean'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $has_one = array(
		'Parent' => 'Page',
		'Link' => 'SiteTree',
		'Image' => 'Image',
		'ProjectPage' => 'ProjectListingPage',
	);

	/**
	 * @var array
	 * @static
	 */
	private static $summary_fields = array(
		'Type' => 'Type',
		'Title' => 'Title',
		'Colour' => 'Colour',
		'Link.Link' => 'Link',
		'ArchivedStatus' => 'Status'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $default_sort = "Sort";

	/**
	 * Returns a FieldList of cms form fields
	 *
	 * @return FieldList
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();

		// Hide these from editing
		$fields->removeByName('ParentID');
		$fields->removeByName('Sort');

		//Remove to re-add
		$fields->removeByName('Type');
		$fields->removeByName('LinkLabel');


        $fields->removeByName('Image');

        $image = FileAttachmentField::create('Image', 'Image');
        $image->setAcceptedFiles(['.jpg, .jpeg, .png'])
            ->setDescription("Format: JPG or PNG <br>Approx dimensions: 400px * 225px")
            ->setFolderName('Uploads/Small-Images')
            ->setMaxFiles(1)
            ->setMultiple(false)
            ->setTrackFiles(true);

        try {
            $image->setView('grid');
        } catch(Exception $e) {}


        $content = $fields->dataFieldByName('Content');
        $numberToDisplay = $fields->dataFieldByName('NumberToDisplay');
        $projectPage = $fields->dataFieldByName('ProjectPageID');
        $html = $fields->dataFieldByName('HTML');
        $subtitle = $fields->dataFieldByName('SubTitle');
        $link = $fields->dataFieldByName('LinkID');
        $html->setRows(20);
        $html->addExtraClass('no-pagebreak');

        $fields->removeByName('Content');
        $fields->removeByName('NumberToDisplay');
        $fields->removeByName('ProjectPageID');
        $fields->removeByName('HTML');
        $fields->removeByName('SubTitle');
        $fields->removeByName('LinkID');

        $fields->addFieldsToTab('Root.Main', [
            $subtitleWrapper = DisplayLogicWrapper::create($subtitle),
            $contentWrapper = DisplayLogicWrapper::create($content),
            $numberToDisplayWrapper = DisplayLogicWrapper::create($numberToDisplay),
            $projectPageWrapper = DisplayLogicWrapper::create($projectPage),
            $htmlWrapper = DisplayLogicWrapper::create($html),
            $linkWrapper = DisplayLogicWrapper::create($link),
        ]);

		$fields->insertAfter(
			$type = OptionSetField::create(
				"Type", "Type",
				$this->dbObject('Type')->enumValues()
			), "Colour"
		);

		$type->addExtraClass('inline-short-list');

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
			), "Title"
		);

		$fields->insertAfter($linkLabel = new TextField("LinkLabel","Link Label"), "LinkID");
		$fields->insertAfter($imageLogin = DisplayLogicWrapper::create($image), 'LinkLabel');
		$imageLogin->displayIf("Type")->isEqualTo("Content");

		$htmlWrapper->displayIf("Type")->isEqualTo("HTML");
		$subtitleWrapper->displayIf("Type")->isEqualTo("HTML");

		$linkWrapper->displayIf("Type")->isEqualTo("Content")->orIf("Type")->isEqualTo("Project");
		$linkLabel->displayIf("LinkID")->isGreaterThan(0)->andIf("Type")->isEqualTo("Content");

		$numberToDisplayWrapper->hideIf("Type")->isEqualTo("Content")->orIf("Type")->isEqualTo("HTML");
		$projectPageWrapper->displayIf("Type")->isEqualTo("Project");

		$contentWrapper->displayIf("Type")->isEqualTo("Content");


		// Archived
		$fields->removeByName('Archived');
		$fields->addFieldToTab('Root.Main', $group = new CompositeField(
			$label = new LabelField("LabelArchive","Archive this feature?"),
			new CheckboxField('Archived', '')
		));

		$group->addExtraClass("special field");
		$label->addExtraClass("left");

		return $fields;
	}

	/**
	 * Returns the anchor tag href attribute for the InternalLink
	 *
	 * @return string
	 */
	public function getLinkHref() {
		if ($this->InternalLinkID) {
			return $this->InternalLink()->Link();
		}
	}

	/**
	 * Returns the anchor tag class attribute for the InternalLink
	 *
	 * @return string (internal link: LinkingMode) | null (external link)
	 */
	public function getLinkClass() {
		if ($this->InternalLinkID) {
			return $this->InternalLink()->LinkingMode();
		}
		return null;
	}

	/**
	 * Returns the anchor tag label
	 *
	 * @return string (internal link: LinkingMode) | null (external link)
	 */
	public function getLinkText() {
		if ($this->LinkLabel) {
			return $this->LinkLabel;
		}
		elseif ($this->InternalLinkID) {
			return $this->InternalLink()->Title();
		}
		return _t('FeatureItem.LinkLabel', 'Read more');
	}

	/**
	 * Returns a description of the 'Archived' attribute state, for display in a GridField summary field
	 *
	 * @return string
	 */
	public function ArchivedStatus() {
		if ($this->Archived == 1) {
			return _t('GridField.Archived', 'Archived');
		}
		return _t('GridField.Live', 'Live');
	}


	public function getEvents() {
		return CalendarHelper::coming_events();
	}

	public function getProjects() {
		return ProjectPage::get()->filter(array('ParentID' => $this->ProjectPageID, 'State' => 'Current'));
	}

	public function CalendarPage() {
		return CalendarPage::get_one('CalendarPage');
	}

	public function NewsPage() {
		return NewsPage::get_one('NewsPage');
	}

	/**
	 * @param Member $member
	 * @return boolean
	 */
	public function canCreate($member = null) {
		return $this->Parent()->canCreate($member);
	}

	/**
	 * @param Member $member
	 * @return boolean
	 */
	public function canEdit($member = null) {
		return $this->Parent()->canEdit($member);
	}

	/**
	 * @param Member $member
	 * @return boolean
	 */
	public function canDelete($member = null) {
		return $this->Parent()->canDelete($member);
	}

	/**
	 * @param Member $member
	 * @return boolean
	 */
	public function canView($member = null) {
		return $this->Parent()->canView($member);
	}
}
