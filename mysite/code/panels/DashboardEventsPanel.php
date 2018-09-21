<?php


/**
 * Defines the "Recent Edits" dashboard panel type
 *
 * @package Dashboard
 * @author Uncle Cheese <unclecheese@leftandmain.com>
 */
class DashboardEventsPanel extends DashboardPanel {


	private static $db = array (
		'Count' => 'Int'
	);



	private static $defaults = array (
		'Count' => 10
	);


	private static $icon = "mysite/images/sitetree_images/event.svg";


	private static $priority = 10;


	public function getLabel() {
		return _t('RecentEvents.LABEL','Recent Events');
	}



	public function getDescription() {
		return _t('RecentEvents.DESCRIPTION','Shows a linked list of recently edited events');
	}



	public function getConfiguration() {
		$fields = parent::getConfiguration();
		$fields->push(TextField::create("Count",_t('DashboardRecentEvents.COUNT','Number of events to display')));
		return $fields;
	}



	/**
	 * Gets the recent edited events, limited to a user provided number of records
	 *
	 * @return ArrayList
	 */
	public function RecentEvents() {
		$records = PublicEvent::get()->sort("LastEdited DESC")->limit($this->Count);
		$set = ArrayList::create([]);
		foreach($records as $r) {
			$set->push(ArrayData::create([
				'EditLink' => Injector::inst()->get("EventArchive")->Link("EditForm/field/File/item/{$r->ID}/edit"),
				'Title' => $r->Title,
                'LastEdited' => $r->obj('LastEdited')
			]));
		}
		return $set;
	}


}