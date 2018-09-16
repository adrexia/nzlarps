<?php
class AddEventPage extends Page {
	private static $db = array(
		'EditContent' => 'HTMLText',
	);

	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->insertAfter(HTMLEditorField::create('EditContent', 'Editing Content'), 'Content');

		return $fields;
	}

	/**
	 * We only want verified members to be able to submit events at this stage
	 * @param Member|int $member
	 * @return bool True if the current user can view this page
	 */
	public function canView($member = null) {
		$member = $member ? $member :  Member::currentUser();

		if (!$member) {
			return false;
		}

		$result = parent::canView($member);

		if ($result && ($member->MembershipStatus==='Verified'|| Permission::check('CMS_ACCESS'))) {
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
		'edit' => true,
		'delete' => true
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

	public function success() {
		return $this->customise([
			'CurrentMenu' => 'myevents',
			'Title' => 'Event Added!',
			'GoodMessage' => 'Thanks! Your event has been successfully added/updated.'
		])->renderWith(['AddEventPage_myevents', 'Page']);
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

		if($event===null || !$event->exists() || !$member || $event->OwnerID !== $member->ID) {
			$hasEvents = $this->getMyEventsLink();
			if ($hasEvents) {
				$this->redirect($hasEvents);
				return false;
			}
			$this->redirect($this->Link());
			return false;
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

	/**
	 * Allow the owners of games to delete events
	 * @param $request
	 * @return mixed
	 */
	public function delete() {
		$params = $this->getURLParams();
		$member = Member::currentUser();
		$event = PublicEvent::get()->byID($params['ID']);

		if($event === null || !$event->exists() || !$member || $event->OwnerID !== $member->ID) {
			$hasEvents = $this->getMyEventsLink();
			if ($hasEvents) {
				$this->redirect($hasEvents);
				return false;
			}
			$this->redirect($this->Link());
			return false;
		}

		try {
			$event->delete();
		} catch(Exception $e) {
			$data = [
				'BadMessage' => 'Technical error: deleting event failed. Please try again later, or contact an admin for assistance.',
			];

			return $this->customise($data)->renderWith(['AddEventPage_myevents', 'Page']);
		}

		$data = [
			'CurrentMenu' => 'myevents',
			'Title' => 'My Events',
			'GoodMessage' => 'Event successfully deleted',
		];

		return $this->customise($data)->renderWith(['AddEventPage_myevents', 'Page']);
	}
}
