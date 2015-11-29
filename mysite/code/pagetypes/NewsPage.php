<?php
class NewsPage extends Page {

	private static $icon = "mysite/images/sitetree_images/news.png";
	public $pageIcon = "mysite/images/sitetree_images/news.png";

	private static $singular_name = 'News Page';
	private static $description = 'A page that lists news and annoucements';


	private static $has_many = array(
		'NewsItems' => 'NewsItem'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();


		$gridField = new GridField(
			'NewsItems',
			'NewsItems',
			$this->NewsItems()->sort(array('Created'=>'ASC', 'Archived'=>'ASC')),
			$config = GridFieldConfig_RelationEditor::create()
		);
		$gridField->setModelClass('NewsItem');
		$fields->addFieldtoTab('Root.News', $gridField);
		$config->addComponent(new GridFieldOrderableRows());

		$fields->removeByName('Content');
		$fields->removeByName('ExtraContent');
		$fields->removeByName('Features');

		return $fields;
	}
	
	public function RecentNews(){
		return $this->NewsItems()->exclude('Archived', 1)->sort(array('Created'=>'DESC'));
	}

}

class NewsPage_Controller extends Page_Controller {


	public function getNews($pageSize = 6) {
		$items = $this->RecentNews();
		// Apply pagination
		$list = new AjaxPaginatedList($items, $this->request);
		$list->setPageLength($pageSize);
		return $list;
	}



}
