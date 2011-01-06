<?php
$db = eZDB::instance();
$newsletter_ini = eZINI::instance( 'jaj_newsletter.ini' );

$table_list = array('jaj_newsletter_subscription_list', 'jaj_newsletter_subscription', 'jaj_newsletter_recipients_list', 'jaj_newsletter_delivery');

$Module = $Params[ 'Module' ];

$setup = array();
$setup["database_ok"] = true;

// Check if database contains tables for extension
//$eZTableList = $db->eZTableList();

foreach ( $table_list as $table ) {
	$sql = "select * from ${table} limit 1";
	$result = $db->query( $sql );
	
	//if ( !isset( $eZTableList[$table] ) ) {

	if($result === false) {
    	$setup["database_ok"] = false;
      	break;	
	}
}

// Check if content class for newsletter exists
$setup["content_classes_ok"] = is_object( eZContentClass::fetchByIdentifier( 'jaj_newsletter' ) );

// Check for newsletter folder
$newsletter_id = $newsletter_ini->variable( 'NewsletterSettings', 'RootFolderNodeId' );
$newsletter_node = eZContentObject::fetchByNodeID($newsletter_id);
$setup["newsletter_folder_ok"] = ( $newsletter_id && is_object( $newsletter_node ) );

$setup["newsletter_settings_ok"] = (
		$newsletter_ini->variable( 'NewsletterSettings', 'FromEmail' ) &&
		$newsletter_ini->variable( 'NewsletterSettings', 'FromName' ) &&
		$newsletter_ini->variable( 'NewsletterSettings', 'ReplyEmail' )
	);

// Check for newsletter section
// And check that newsletter node is assigned to section
//$section = eZSection::fetchByIdentifier("jaj_newsletter");

$sections = eZSection::fetchList();

foreach( $sections as $s ) {
	if( $s->attribute("identifier") == "jaj_newsletter" ) {
		$section = $s;
		break;
	}
}


if( is_object($newsletter_node) && is_object( $section ) ) {
	$setup["newsletter_section_ok"] = ( $newsletter_node->SectionID == $section->ID );
} else {
	$setup["newsletter_section_ok"] = false;
}

// TODO: Add check for access rights for section
$anonymous = eZUser::fetch( eZUser::anonymousId() );
//var_dump( $anonymous );
$jaj_subscription_access = $anonymous->hasAccessTo('jaj_newsletter', 'manage_subscription');
$setup["newsletter_sub_access_ok"] = ( $jaj_subscription_access["accessWord"] == "yes" );

$tpl = eZTemplate::factory();
$tpl->setVariable( 'setup', $setup );

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/settings/view.tpl' ),
    'path'    => array(
        array( 
			'url' => 'jaj_newsletter/index', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
		),
		array(
			'url' => false, 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Settings' ),		
		)
    )
);

?>