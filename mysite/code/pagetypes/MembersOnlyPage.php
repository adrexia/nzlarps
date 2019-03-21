<?php
class MemberOnlyPage extends Page {

    private static $description = 'A page only viewable by verified members';

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('MemberOnlyContent');
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

class MemberOnlyPage_Controller extends Page_Controller {

	public function init() {
		parent::init();
	}
}
