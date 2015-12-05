<?php

global $project;
$project = 'mysite';

global $database;

// find the database name from the environment file
if(defined('SS_DATABASE_NAME') && SS_DATABASE_NAME) {
	$database = SS_DATABASE_NAME;
} else {
	$database = 'SS_nzlarps';
}

require_once('conf/ConfigureFromEnv.php');

// Set the site locale
i18n::set_locale('en_US');

CalendarConfig::init(array(
	'categories' => array(
		'enabled' => false,
	)
));

$standardsEditor = HtmlEditorConfig::get('standards');

$standardsEditor->setOptions(array(
	'theme_advanced_buttons3' => 'pagebreak',
	'pagebreak_separator' => '<span class="break"><!--break--></span>',
));

$standardsEditor->enablePlugins('pagebreak');
$standardsEditor->insertButtonsAfter('separator', 'pagebreak');
