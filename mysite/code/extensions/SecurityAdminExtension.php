<?php
/*
* Admin for current event
*/

class SecurityAdminExtension extends Extension {

	public function updateEditForm($form) {

		$gridField = $form->Fields()->fieldByName('Root.Users.Members');

		$gridField->getConfig()->getComponentByType('GridFieldExportButton')
			->setExportColumns(
				singleton($this->sanitiseClassName('Member'))->getExportFields()
			);

	}

	/**
	 * Sanitise a model class' name for inclusion in a link
	 * @return string
	 */
	public function sanitiseClassName($class) {
		return str_replace('\\', '-', $class);
	}
}
