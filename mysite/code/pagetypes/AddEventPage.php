<?php
class AddEventPage extends Page {
	private static $db = array(
		'Success' => 'HTMLText'
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter(HTMLEditorField::create('Success', 'Success Content'), 'Content');

		return $fields;
	}

}

class AddEventPage_Controller extends Page_Controller {

	private static $allowed_actions = array (
		'Form',
		'success'
	);

	public function init() {
		parent::init();

	}

	public function Form() {
		return new AddEventForm($this, 'Form');
	}

	public function Content() {
		return $this->Content;
	}
}
