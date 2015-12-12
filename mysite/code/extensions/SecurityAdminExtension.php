<?php
/*
* Admin for current event
*/

class SecurityAdminExtension extends Extension {

	public function updateEditForm($form) {

		$gridField = $form->Fields()->fieldByName('Root.Users.Members');
		$config = $gridField->getConfig();

		$config->getComponentByType('GridFieldExportButton')
			->setExportColumns(
				singleton($this->sanitiseClassName('Member'))->getExportFields()
			);

		$columns = $config->getComponentByType('GridFieldDataColumns');

		$columns->setFieldFormatting(array(
			'MemberNumber' => function($value, $item) {
				return $item->prepMemberNumber();
			},
			'LastEdited' => function($value, $item) {
				return $item->LastEditedNice();
			}
		));

		$config->getComponentByType('GridFieldPaginator')->setItemsPerPage(100);


	}

	/**
	 * Sanitise a model class' name for inclusion in a link
	 * @return string
	 */
	public function sanitiseClassName($class) {
		return str_replace('\\', '-', $class);
	}
}
