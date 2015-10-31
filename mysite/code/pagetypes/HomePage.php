<?php
class HomePage extends Page {

	private static $icon = "mysite/images/sitetree_images/home.png";
	public $pageIcon = "mysite/images/sitetree_images/home.png";

	private static $has_one = array(
		'JoinLink' => 'Link'
	);

	private static $has_many = array(
		'FeatureItems' => 'FeatureItem'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertBefore(LinkField::create('JoinLinkID', 'JoinLink'), 'Content');


		$gridField = new GridField(
			'FeatureItems',
			'FeatureItems',
			$this->FeatureItems()->sort(array('Sort'=>'ASC','Archived'=>'ASC')),
			$config = GridFieldConfig_RelationEditor::create()
		);
		$gridField->setModelClass('FeatureItem');
		$fields->addFieldToTab('Root.Features', $gridField);
		$config->addComponent(new GridFieldOrderableRows());

		$fields->removeByName('Content');

		return $fields;
	}

}

class HomePage_Controller extends Page_Controller {

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
