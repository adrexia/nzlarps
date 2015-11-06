<?php
class NewsPage extends Page {

	private static $icon = "mysite/images/sitetree_images/home.png";
	public $pageIcon = "mysite/images/sitetree_images/home.png";

	private static $singular_name = 'News Page';
	private static $description = 'A page to list news.';


	private static $has_many = array(
		'NewsItems' => 'NewsItem'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertBefore(LinkField::create('JoinLinkID', 'JoinLink'), 'Content');


		$gridField = new GridField(
			'NewsItems',
			'NewsItems',
			$this->NewsItems()->sort(array('Sort'=>'ASC','Archived'=>'ASC')),
			$config = GridFieldConfig_RelationEditor::create()
		);
		$gridField->setModelClass('NewsItems');
		$fields->addFieldToTab('Root.News', $gridField);
		$config->addComponent(new GridFieldOrderableRows());

		$fields->removeByName('Content');

		return $fields;
	}

}

class NewsPage_Controller extends Page_Controller {


	public function getNews($pageSize = 5) {
		$items =  $this->NewsItems()->sort(array('Sort'=>'ASC','Created'=>'ASC'));
		// Apply pagination
		$list = new AjaxPaginatedList($items, $this->request);
		$list->setPageLength($pageSize);
		return $list;
	}

	public function RecentNews($pageSize = 10){
		return $this->NewsItems()->Limit($pageSize);
	}

}
