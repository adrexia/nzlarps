<?php
class AddEventPage extends Page {
	private static $db = array(
		'Success' => 'HTMLText',
		'EditContent' => 'HTMLText',
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter(HTMLEditorField::create('Success', 'Success Content'), 'Content');
		$fields->insertAfter(HTMLEditorField::create('EditContent', 'Editing Content'), 'Success');

		return $fields;
	}

    /**
     * We only want verified members to be able to submit events at this stage
     * @param Member|int $member
     * @return bool True if the current user can view this page
     */
    public function canView($member = null) {

        $result = parent::canView($member);

        if(!$result) {
            return false;
        }

        $member = Member::currentUser();

        if ($member->MembershipStatus==='Verified'|| Permission::check('ADMIN') || Permission::check('CMS_ACCESS')) {
            return true;
        }

        return false;
    }

}

class AddEventPage_Controller extends Page_Controller {

	private static $allowed_actions = array (
		'Form' => true,
		'success' => true,
		'myevents' => true,
		'edit' => true
	);

	public function init() {
		parent::init();
	}

	public function Form() {
		return AddEventForm::create($this, 'Form');
	}

	public function Content() {
		return $this->Content;
	}

	public function myevents() {
		return $this->customise([
			'CurrentMenu' => 'myevents',
			'Title' => 'My Events'
		])->render();
	}

	/**
	 * Allow the owners of games to edit events
	 * If page is reached by non owners, redirect back to the add form
	 * @param $request
	 * @return mixed
	 */
	public function edit() {
		$params = $this->getURLParams();
		$member = Member::currentUser();
		$event = PublicEvent::get()->byID($params['ID']);

		if(!$event || !$member || $event->OwnerID !== $member->ID) {
			$this->redirect($event->AbsoluteLink());
		}

		$form = $this->Form();
		$form->loadDataFrom($event);

		$data = [
			'Title' => 'Edit: ' . $event->Title,
			'Form' => $form,
			'Content' => $this->obj('EditContent')
		];

		return $this->customise($data)->render();
	}


}
