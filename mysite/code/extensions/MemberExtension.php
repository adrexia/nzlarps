<?php
/**
 * Adds new global membership fields.
 */

class MemberExtension extends DataExtension {

	private static $db = array(
		'Notified' => 'Boolean', // stores whether an expiry email has been sent
		'HomePhone' => 'Varchar(255)',
		'WorkPhone' => 'Varchar(255)',
		'MobilePhone' => 'Varchar(255)',
		'Address' => 'Text',
		'Occupation' => 'Varchar(255)',
		'BirthDate' => 'Varchar(255)',

		'MemberNumber' => 'Int', //onBeforeWrite, if empty.
		'MembershipStatus' => 'Enum("Applied, Verified, Expired, Not applied", "Applied")', //needs a cronjob to expire
		'ExpiryDate' => 'Date',
		'Discount' => 'Enum("Applied, Verified, Expired, Not applied", "Not applied")', //needs a cronjob to expire
		'DiscountExpiryDate' => 'Date',
		'NotesForMember' => 'Text',
		'JoinedDate' => 'Date',
	);

	private static $has_one = array(
		'Region' => 'Region'
	);

	/**
	 * @var array
	 * @static
	 */
	private static $summary_fields = array(
		'Region.Title',
		'MembershipStatus',
		'MemberNumber',
		'ExpiryDate',
		'JoinedDate',
		'LastEdited'
	);


	/**
	 * Sets the Date field to the current date.
	 */
	public function populateDefaults() {
		$this->owner->ExpiryDate = date('Y-m-d', strtotime('+1 year'));
		$this->owner->Notified = 0;
		parent::populateDefaults();
	}

	public function prepMemberNumber() {
		if ($this->owner->MembershipStatus !== "Not applied") {
			return $this->owner->MemberNumber;
		} else {
			return 0;
		}
	}


	public function updateCMSFields(FieldList $fields) {

		$fields->insertBefore(new Tab('MembershipDetails', 'Membership Details'), 'Main');

		//move first and ;astname
		$fields->addFieldToTab('Root.MembershipDetails', $fields->dataFieldByName('FirstName'));
		$fields->addFieldToTab('Root.MembershipDetails', $fields->dataFieldByName('Surname'));
		$fields->addFieldToTab('Root.MembershipDetails', $fields->dataFieldByName('Email'));

		$fields->addFieldToTab('Root.MembershipDetails', $region = DropdownField::create(
			'RegionID',
			'Region',
			Region::get()->map('ID', 'Title')
		));

		$region->setEmptyString(' ');

		$fields->addFieldToTab('Root.MembershipDetails', DropdownField::create(
			'MembershipStatus',
			'Membership Status',
			$this->owner->dbObject('MembershipStatus')->enumValues()
		));

		$fields->addFieldToTab('Root.MembershipDetails', $expiry = DateField::create('ExpiryDate'));

		$fields->addFieldToTab('Root.MembershipDetails', DropdownField::create(
			'Discount',
			'Discount',
			$this->owner->dbObject('Discount')->enumValues()
		));

		$fields->addFieldToTab('Root.MembershipDetails', $discountExpiry = DateField::create('DiscountExpiryDate'));

		$fields->addFieldToTab('Root.MembershipDetails', $joined = DateField::create('JoinedDate'));

		$fields->addFieldToTab('Root.MembershipDetails', TextareaField::create('NotesForMember'));

		if ($this->owner->MembershipStatus !== "Not applied") {
			$fields->addFieldToTab('Root.MembershipDetails', TextField::create('MemberNumber'));
		}

		$fields->addFieldToTab('Root.MembershipDetails', TextField::create('HomePhone'));
		$fields->addFieldToTab('Root.MembershipDetails', TextField::create('WorkPhone'));
		$fields->addFieldToTab('Root.MembershipDetails', TextField::create('MobilePhone'));
		$fields->addFieldToTab('Root.MembershipDetails', TextareaField::create('Address'));
		$fields->addFieldToTab('Root.MembershipDetails', TextField::create('Occupation'));
		$fields->addFieldToTab('Root.MembershipDetails', TextField::create('BirthDate'));


		$expiry->setConfig('showcalendar', true);
		$expiry->setConfig('showdropdown', true);
		$expiry->setConfig('dateformat', 'dd-MM-YYYY');

		$discountExpiry->setConfig('showcalendar', true);
		$discountExpiry->setConfig('showdropdown', true);
		$discountExpiry->setConfig('dateformat', 'dd-MM-YYYY');


		$joined->setConfig('showcalendar', true);
		$joined->setConfig('showdropdown', true);
		$joined->setConfig('dateformat', 'dd-MM-YYYY');

	}

	public function LastEditedNice() {
		return $this->owner->dbObject('LastEdited')->Nice();
	}


	public function onBeforeWrite() {
		parent::onBeforeWrite();

		if(!$this->owner->MemberNumber) {
			$this->owner->MemberNumber = Member::get()->sort('ID')->last()->ID + 300;
		}

		if(!$this->owner->JoinedDate && $this->owner->MembershipStatus==='Verified') {
			$this->owner->JoinedDate = date('Y-m-d');
		}

		if($this->owner->isChanged('MembershipStatus') && $this->owner->MembershipStatus==='Verified') {
			$email = new MemberApprovalEmail(RegistrationPage::get_one('RegistrationPage'), $this->owner);
			$email->send();
			$this->Notified = 0;
		}

	}

	public function getExportFields() {
		return array(
			'FirstName' => 'FirstName',
			'Surname' => 'Surname',
			'Email' => 'Email',

			'HomePhone' => 'Home Phone',
			'WorkPhone' => 'Work Phone',
			'MobilePhone' => 'Mobile Phone',
			'Address' => 'Address',
			'Occupation' => 'Occupation',
			'BirthDate' => 'Birth Date',

			'MemberNumber' => 'Member Number',
			'MembershipStatus' => 'Membership Status',
			'ExpiryDate' => 'Expiry Date',
			'Discount' => 'Discount',
			'DiscountExpiryDate' => 'Discount Expiry Date',

			'NotesForMember' => 'Notes For Member',
			'JoinedDate' => 'Joined Date',

			'Region.Title' => 'Region'
		);
	}

}
