<?php

class NewsItem extends DataObject {
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Author' => 'Varchar(255)',
		'Colour' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Archived' => 'Boolean',
		'Sort' => 'Int'
	);


	private static $has_one = array(
		'Parent' => 'Page',
	);

	private static $summary_fields = array(
		'Title' => 'Title',
		'Content.ContextSummary' => 'Content',
		'ArchivedReadable' => 'Current Status'
	);

	public static $default_sort = 'Sort';

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Archived');
		$fields->removeByName('Sort');

		$fields->addFieldToTab('Root.Main', $group = new CompositeField(
			$label = new LabelField("LabelArchive","Archive this news item?"),
			new CheckboxField('Archived', '')
		));

		$group->addExtraClass("field special");
		$label->addExtraClass("left");

		$fields->removeByName('ParentID');

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
			), "Title"
		);

		return $fields;
	}

	public function ArchivedReadable(){
		if($this->Archived == 1) return _t('GridField.Archived', 'Archived');
		return _t('GridField.Live', 'Live');
	}

	public function Link() {
		$newsPage = NewsPage::get_one('NewsPage');
		return $newsPage->Link() . '#ID-' . $this->ID;
	}

	public function canCreate($member = null) {
		return $this->Parent()->canCreate($member);
	}

	public function canEdit($member = null) {
		return $this->Parent()->canEdit($member);
	}

	public function canDelete($member = null) {
		return $this->Parent()->canDelete($member);
	}

	public function canView($member = null) {
		return $this->Parent()->canView($member);
	}

}
