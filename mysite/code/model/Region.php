<?php
/**
 * Region DataObject
 *
 * @category model
 *
 */
class Region extends DataObject implements PermissionProvider {

	/**
	 * @var array
	 * @static
	 */
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Colour' => 'Varchar(255)',
		'Intro' => 'Text',
		'Content' => 'HTMLText',
		'Sort' => 'Int',
		'Archived' => 'Boolean',
		'HideFromRegionLists' => 'Boolean'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $has_one = array(
		'Parent' => 'Page',
		'SplashImage' => 'Image'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $summary_fields = array(
		'Title' => 'Title',
		'Colour' => 'Colour',
		'ArchivedStatus' => 'Status'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $default_sort = "Sort";

	/**
	 * Returns a FieldList of cms form fields that is the main form for editing this DataObject
	 *
	 * @return FieldList
	 */
	public function getCMSFields() {
		$fields = parent::getCMSFields();

		// Hide these from editing
		$fields->removeByName('ParentID');
		$fields->removeByName('Sort');

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
			), "Title"
		);


		$fields->removeByName('HideFromRegionLists');


		// Archived
		$fields->removeByName('Archived');
		$fields->addFieldToTab('Root.Main', $group = new CompositeField(
			$labelHide = new LabelField("LabelHideFromRegionLists","Hide from region lists?"),
			new CheckboxField('HideFromRegionLists',
			"e.g. if you need a region for an event that isn't a branch location"),
			$label = new LabelField("LabelArchive","Archive this region?"),
			new CheckboxField('Archived', '')
		));

		$labelHide->addExtraClass("left");

		$group->addExtraClass("special field");
		$label->addExtraClass("left");

		return $fields;
	}


	/*
	 * Returns the url suffix to append to the current controllors url
	 */
	public function URLSegment($action = 'region') {
		return Controller::join_links($action, $this->ID);
	}

	public function getColourName() {
		if($this->Colour) {
			return $this->Colour;
		} else {
			return 'air';
		}
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

	public function canView($member = null) {
		return Permission::check('REGION_VIEW');
	}
	public function canEdit($member = null) {
		return Permission::check('REGION_EDIT');
	}
	public function canDelete($member = null) {
		return Permission::check('REGION_DELETE');
	}
	public function canCreate($member = null) {
		return Permission::check('REGION_CREATE');
	}
	/**
	 * Get an array of {@link Permission} definitions that this object supports
	 *
	 * @return array
	 */
	public function providePermissions() {
		return array(
			'REGION_VIEW' => array(
				'name' => 'View region admin',
				'category' => 'Regions',
			),
			'REGION_EDIT' => array(
				'name' => 'Edit regions',
				'category' => 'Regions',
			),
			'REGION_DELETE' => array(
				'name' => 'Delete regions',
				'category' => 'Regions',
			),
			'REGION_CREATE' => array(
				'name' => 'Create regions',
				'category' => 'Regions'
			)
		);
	}

}
