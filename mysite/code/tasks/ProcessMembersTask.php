<?php

class ProcessMembersTask extends BuildTask implements CronTask {

	protected $title = "Process Members";

	protected $description = "Send emails to expirying members. Update expired Memberships.";

	/**
	 * Main task function
	 */
	public function run($request)  {
		$this->handleExpiryingMembers();
		$this->handleExpiredMembers();
	}

	public function handleExpiryingMembers() {
		$expiringMembers = $this->getExpiringMembers();
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
				} catch (Exception $e) {
					echo '<p>Failed to send email, or update: ' . $member->FirstName . '</p>' ;
				}
			}
		}

		echo '<p>' . $count . ' members notified of expirying membership</p>';


	}

	public function handleExpiredMembers() {
		$expiredMembers = $this->getExpiredMembers();
		$count = 0;

		foreach($expiredMembers as $member) {
			$member->MembershipStatus = 'Expired';

			try {
				$member->write();
				$count++;
			} catch(ValidationException $e) {
				echo '<p>Failed to update record: ' . $member->FirstName . '</p>' ;
			}
		}

		echo '<p>' . $count . ' members set to expired</p>';
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
		$today = $date->setTimestamp(strtotime('now'));

		return Member::get()->filter(array(
			'MembershipStatus' => 'Verified',
			'ExpiryDate' => $today->format('Y-m-d H:i:s')
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
