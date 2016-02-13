<?php

class ProcessMembersTask extends BuildTask implements CronTask {

	protected $title = "Process Members";

	protected $description = "Send emails to expirying members. Update expired Memberships.";

	/**
	 * Main task function
	 */
	public function run($request)  {
		$expiring = $this->getExpiringMembers();
		$expired = $this->getExpiredMembers();
		$newMembers = $this->getApplyingMembers();

		if ($expiring->Count() > 0 || $expired->Count() > 0 || $newMembers->Count() > 0) {
			$this->emailReport($expired, $expiring, $newMembers);
		}

		$this->handleExpiryingMembers($expiring);
		$this->handleExpiredMembers($expired);
	}


	public function emailReport($expired, $expiring, $newMembers) {
		$email = Email::create();

		$to = 'secretary@nzlarps.org, treasurer@nzlarps.org';

		$email->setTo($to);
		$email->setBcc('it@nzlarps.org');
		$email->setSubject("NZLarps daily membership report");

		$content = $email->customise(new ArrayData(array(
			'NewMembers' => $newMembers,
			'ExpiredMembers' => $expired,
			'ExpiryingMembers' => $expiring
		)))->renderWith('ReportEmail');

		$email->setBody($content);
		$email->send();

		echo '<p>Report has been sent</p>';
	}


	public function handleExpiryingMembers($expiringMembers) {
		$register = RegistrationPage::get_one('RegistrationPage');

		$count = 0;

		if($expiringMembers->Count() > 0) {

			foreach($expiringMembers as $member) {
				$member->Notified = 1;

				try {
					$email = new MemberReminderEmail($register, $member);
					$email->send();

					$member->write();
					$count++;

					echo '<p>Email sent to:' . $member->Email . ' </p>';

				} catch (Exception $e) {
					echo '<p>Failed to send email, or update: ' . $member->FirstName . '</p>' ;
				}
			}
		}

		echo '<p>' . $count . ' members notified of expirying membership</p>';

		return $expiringMembers;
	}

	public function handleExpiredMembers($expiredMembers) {
		$register = RegistrationPage::get_one('RegistrationPage');
		$count = 0;

		if($expiredMembers->Count() > 0) {

			foreach($expiredMembers as $member) {

				$member->MembershipStatus = 'Expired';

				try {
					$email = new MemberExpiredEmail($register, $member);
					$email->send();

					$member->write();
					$count++;

					echo '<p>Email sent to:' . $member->Email . ' </p>';

				} catch(ValidationException $e) {
					echo '<p>Failed to update record: ' . $member->FirstName . '</p>' ;
				}
			}
		}

		echo '<p>' . $count . ' members notified of expired membership</p>';

		return $expiredMembers;
	}

	// Notify members due to expire in 29 days
	public function getExpiringMembers() {
		$date = new DateTime();
		$end = $date->setTimestamp(strtotime('+30 days'));

		return Member::get()->filter(array(
			'MembershipStatus' => 'Verified',
			'ExpiryDate:LessThan' => $end->format('Y-m-d H:i:s'),
			'Notified' => 0
		));
	}

	public function getExpiredMembers() {
		$date = new DateTime();
		$tomorrow = $date->setTimestamp(strtotime('tomorrow'));

		return Member::get()->filter(array(
			'MembershipStatus' => 'Verified',
			'ExpiryDate:LessThan' => $tomorrow->format('Y-m-d H:i:s')
		));
	}

	public function getApplyingMembers() {
		return Member::get()->filter(array(
			'MembershipStatus' => 'Applied'
		));
	}


	/**
	*
	* @return string
	*/
	public function getSchedule() {
		return "0 1 * * *";
	}

	/**
	*
	* @return void
	*/
	public function process() {
		$this->run(SS_HTTPRequest::create());
	}
}
