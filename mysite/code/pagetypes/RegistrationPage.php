<?php
/**
 * Customisation to the MemberProfilePage from the memberprofile module, to deal with event specific fields
 */

class RegistrationPage extends MemberProfilePage {

	private static $hide_ancestor = "MemberProfilePage";

	private static $singular_name = 'Registration Page';
	private static $description = 'Lets users signup for NZLarps membership, and check their details.';


	private static $db = array(
		'ApprovalEmailSubject'  => 'Varchar(255)',
		'ApprovalEmailTemplate' => 'Text',
		'ExpiryReminderEmailSubject' => 'Varchar(255)',
		'ExpiryReminderEmailTemplate' => 'Text',
		'ExpiryEmailSubject' => 'Varchar(255)',
		'ExpiryEmailTemplate' => 'Text'
	);


	public function getCMSFields() {
		$fields = parent::getCMSFields();

		$fields->removeByName('Features');
		$fields->removeByName('ExtraContent');

		$regContent = $fields->dataFieldByName('RegistrationContent');
		$afterContent = $fields->dataFieldByName('AfterRegistrationContent');
		$profileContent = $fields->dataFieldByName('ProfileContent');

		$regContent->addExtraClass('no-pagebreak');
		$afterContent->addExtraClass('no-pagebreak');
		$profileContent->addExtraClass('no-pagebreak');

		$fields->insertAfter(TextareaField::create('ApprovalEmailTemplate','Approval Email Template'), 'EmailTemplate');
		$fields->insertAfter(TextField::create('ApprovalEmailSubject','Approval Email Subject'), 'EmailTemplate');

		$fields->insertAfter(TextareaField::create('ExpiryReminderEmailTemplate','Expiry Reminder Email Template'), 'ApprovalEmailTemplate');
		$fields->insertAfter(TextField::create('ExpiryReminderEmailSubject','Expiry Reminder Email Subject'), 'ApprovalEmailTemplate');

		$fields->insertAfter(TextareaField::create('ExpiryEmailTemplate','Expiry Email Template'), 'ExpiryReminderEmailTemplate');
		$fields->insertAfter(TextField::create('ExpiryEmailSubject','Expiry Email Subject'), 'ExpiryReminderEmailTemplate');


		$fields->addFieldToTab('Root.Members', LiteralField::create(
			'MembersNote', '<p class="message"><strong>Note:</strong> This list has been filtered to include current and pending members only. Use the Members admin area for handling expired memberships and non-member website users.</p>'
		));

		$members = Member::get()->exclude(array(
			'MembershipStatus'=>'Not applied'
		))->exclude(array(
			'MembershipStatus'=>'Expired'
		))->sort(array('ExpiryDate'=> 'ASC'));

		$gridField = new GridField(
			'Members',
			'NZLARP Members',
			$members,
			$config = GridFieldConfig_RecordEditor::create()
		);

		$gridField->setModelClass('Member');
		$columns = $config->getComponentByType('GridFieldDataColumns');

		$columns->setFieldFormatting(array(
			'LastEdited' => function($value, $item) {
				return $item->LastEditedNice();
			}
		));

		$columns->setDisplayFields(array(
			'getName' => 'Name',
			'Region.Title' => 'Region',
			'MembershipStatus' => 'Status',
			'ExpiryDate'=>'Expires',
			'LastEdited'=>'Last Activity'
		));


		$fields->addFieldToTab('Root.Members', $gridField);

		$config->getComponentByType('GridFieldPaginator')->setItemsPerPage(200);

		$config->addComponent(new GridFieldExportButton('buttons-before-left'));


		return $fields;
	}

}

class RegistrationPage_Controller extends MemberProfilePage_Controller {

	private static $allowed_actions = array (
		'index',
		'RegisterForm',
		'afterregistration',
		'ProfileForm',
		'add',
		'AddForm',
		'confirm',
		'show'
	);
	/**
	 * @uses   MemberProfilePage_Controller::indexRegister
	 * @uses   MemberProfilePage_Controller::indexProfile
	 * @return array
	 */
	public function index() {
		if (isset($_GET['BackURL'])) {
			Session::set('MemberProfile.REDIRECT', $_GET['BackURL']);
		}
		$mode = Member::currentUser() ? 'profile' : 'register';
		$data = Member::currentUser() ? $this->indexProfile() : $this->indexRegister();

		// Need to check if already a member but no current registration, and show indexProfile with extra fields
		// If member and registration, need to hide from main menu (but allow from login edit)

		if (is_array($data)) {
			return $this->customise($data)->renderWith(array('MemberProfilePage_'.$mode, 'MemberProfilePage', 'Page'));
		}
		return $data;
	}

	/**
	 * Allow users to register if registration is enabled.
	 *
	 * @return array
	 */
	protected function indexRegister() {
		if(!$this->AllowRegistration) return Security::permissionFailure($this, _t (
			'MemberProfiles.CANNOTREGPLEASELOGIN',
			'You cannot register on this profile page. Please login to edit your profile.'
		));

		return array (
			'Title'   => $this->obj('RegistrationTitle'),
			'Content' => $this->obj('RegistrationContent'),
			'Form'    => $this->RegisterForm()
		);
	}


	/**
	 * Handles validation and saving new Member objects, as well as sending out validation emails.
	 */
	public function register($data, Form $form) {
		if($member = $this->addMember($form)) {
			$this->addRegistration($form, $member);


			if(!$this->RequireApproval && $this->EmailType != 'Validation' && !$this->AllowAdding) {
				$member->logIn();
			}

			if ($this->RegistrationRedirect) {
				if ($this->PostRegistrationTargetID) {
					$this->redirect($this->PostRegistrationTarget()->Link());
					return;
				}

				if ($sessionTarget = Session::get('MemberProfile.REDIRECT')) {
					Session::clear('MemberProfile.REDIRECT');
					if (Director::is_site_url($sessionTarget)) {
						$this->redirect($sessionTarget);
						return;
					}
				}
			}


			return $this->redirect($this->Link('afterregistration'));
		} else {
			return $this->redirectBack();
		}
	}


	/**
	 * Attempts to save a registration
	 *
	 * @return Member|null
	 */
	protected function addRegistration($form, $member) {
		$member = new Member();

		$form->saveInto($member);

		try {
			$member->write();
		} catch(ValidationException $e) {
			$form->sessionMessage($e->getResult()->message(), 'bad');
			return;
		}

		$this->sendAdminEmail($member);

		return $member;
	}


	public function getRegistration($memberID) {
		return Member::get()->byID($memberID);
	}



	/**
	 * Allows users to edit their profile if they are in at least one of the
	 * groups this page is restricted to, and editing isn't disabled.
	 *
	 * If editing is disabled, but the current user can add users, then they
	 * are redirected to the add user page.
	 *
	 * @return array
	 */
	protected function indexProfile() {
		if(!$this->AllowProfileEditing) {
			if($this->AllowAdding && Injector::inst()->get('Member')->canCreate()) {
				return $this->redirect($this->Link('add'));
			}

			return Security::permissionFailure($this, _t(
				'MemberProfiles.CANNOTEDIT',
				'You cannot edit your profile via this page.'
			));
		}

		$member = Member::currentUser();
		$registration = $this->getRegistration($member->ID);

		foreach($this->Groups() as $group) {
			if(!$member->inGroup($group)) {
				return Security::permissionFailure($this);
			}
		}

		$form = $this->ProfileForm();

		$form->loadDataFrom($member);

		if($registration){
			$form->loadDataFrom($registration);
		}

		if($password = $form->Fields()->fieldByName('Password')) {
			$password->setCanBeEmpty(false);
			$password->setValue(null);
			$password->setCanBeEmpty(true);
		}

		return array (
			'Title' => $this->obj('ProfileTitle'),
			'Content' => $this->obj('ProfileContent'),
			'Form'  => $form
		);
	}


	/**
	 * @uses   MemberProfilePage_Controller::getProfileFields
	 * @return Form
	 */
	public function RegisterForm() {
		$fields = $this->getProfileFields('Registration');
		$fields = $this->RegistrationFields($fields);

		$form = new Form (
			$this,
			'RegisterForm',
			$fields,
			new FieldList(
				new FormAction('register', _t('MemberProfiles.REGISTER', 'Register'))
			),
			new MemberProfileValidator($this->Fields())
		);

		$form->enableSpamProtection();

		$this->extend('updateRegisterForm', $form);

		return $form;
	}

	public function RegistrationFields($fields) {

		$fields->push(TextField::create('HomePhone'));
		$fields->push(TextField::create('WorkPhone'));
		$fields->push(TextField::create('MobilePhone'));
		$fields->push(TextareaField::create('Address'));
		$fields->push(TextField::create('Occupation'));
		$fields->push(TextField::create('BirthDate'));


		return $fields;
	}


	/**
	 * @uses   MemberProfilePage_Controller::getProfileFields
	 * @return Form
	 */
	public function ProfileForm() {
		$fields = $this->getProfileFields('Profile');
		$fields = $this->RegistrationFields($fields);

		$member = Member::currentUser();
		$actionTitle = 'Save';

		if($member->MembershipStatus === 'Expired') {
			$actionTitle = 'Renew';
		}

		if($member->MembershipStatus === 'Not applied') {
			$actionTitle = 'Join';
		}

		$form = new Form (
			$this,
			'ProfileForm',
			$fields,
			new FieldList(
				new FormAction('save', $actionTitle)
			),
			new MemberProfileValidator($this->Fields(), Member::currentUser())
		);

		$form->enableSpamProtection();

		$this->extend('updateProfileForm', $form);
		return $form;
	}

	public function sendAdminEmail($member) {
		$email = Email::create();

		$email->setTo('secretary@nzlarps.org');
		$email->setBcc('it@nzlarps.org');
		$email->setSubject("New member application");

		$content = $this->customise(new ArrayData(array(
			'Member' => $member
		)))->renderWith('NewMemberEmail');

		$email->setBody($content);
		$email->send();
	}

	/**
	 * Updates an existing Member's profile.
	 */
	public function save(array $data, Form $form) {
		$member = Member::currentUser();

		if($member->MembershipStatus === 'Expired' || $member->MembershipStatus === 'Not applied') {
			$member->MembershipStatus = 'Applied';
			$email = new MemberConfirmationEmail($this, $member);
			$email->send();

			$this->sendAdminEmail($member);
		}

		$groupIds = $this->getSettableGroupIdsFrom($form, $member);
		$member->Groups()->setByIDList($groupIds);

		$form->saveInto($member);

		try {
			$member->write();
		} catch(ValidationException $e) {
			$form->sessionMessage($e->getResult()->message(), 'bad');
			return $this->redirectBack();
		}

		$form->sessionMessage (
			'Your details have been updated.',
			'good'
		);



		return $this->redirectBack();
	}



}
