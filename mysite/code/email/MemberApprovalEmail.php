<?php
/**
 * An email sent to the user with a link to validate and activate their account.
 *
 * @package silverstripe-memberprofiles
 */
class MemberApprovalEmail extends Email {

	/**
	 * The default confirmation email subject if none is provided.
	 *
	 * @var string
	 */
	const DEFAULT_SUBJECT = '$SiteName Membership Approved';

	/**
	 * The default email template to use if none is provided.
	 *
	 * @var string
	 */
	const DEFAULT_TEMPLATE = '
<p>
	Dear $Member.FirstName,
</p>

<p>
	Thank you for joining NZLarps!
</p>';


	/**
	 * Replaces variables inside an email template according to {@link TEMPLATE_NOTE}.
	 *
	 * @param string $string
	 * @param Member $member
	 * @return string
	 */
	public static function get_parsed_string($string, $member, $page) {
		$variables = array (
			'$SiteName'       => SiteConfig::current_site_config()->Title,
			'$LoginLink'      => Director::absoluteURL(singleton('Security')->Link('login')),
			'$ConfirmLink'    => Director::absoluteURL(Controller::join_links (
				$page->Link('confirm'),
				$member->ID,
				"?key={$member->ValidationKey}"
			)),
			'$LostPasswordLink' => Director::absoluteURL(singleton('Security')->Link('lostpassword')),
			'$Member.Created'   => $member->obj('Created')->Nice()
		);

		foreach(array('Name', 'FirstName', 'Surname', 'Email') as $field) {
			$variables["\$Member.$field"] = $member->$field;
		}

		return str_replace(array_keys($variables), array_values($variables), $string);
	}

	/**
	 * @param MemberProfilePage $page
	 * @param Member $member
	 */
	public function __construct($page, $member) {
		$from    = $page->EmailFrom ? $page->EmailFrom : Email::getAdminEmail();
		$to      = $member->Email;
		$subject = self::get_parsed_string($page->ApprovalEmailSubject, $member, $page);
		$body    = self::get_parsed_string($page->ApprovalEmailTemplate, $member, $page);

		parent::__construct($from, $to, $subject, $body);
	}

}
