<?php
$Module = $Params[ 'Module' ];

$tpl = eZTemplate::factory();

$newsletter_ini = eZINI::instance( 'jaj_newsletter.ini' );
$newsletter_root_node_id = $newsletter_ini->variable( 'NewsletterSettings', 'RootFolderNodeId' );
$node = eZContentObject::fetchByNodeID($newsletter_root_node_id);

if ( !$node || !$node->canRead() )
	return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

switch( eZPreferences::value( 'admin_jaj_newsletter_newsletters_limit' ) )
{
	case '25': { $limit = 25; } break;
	case '50': { $limit = 50; } break;
	default:  { $limit = 10; } break;
}

$newsletter_content_class = eZContentClass::fetchByIdentifier( 'jaj_newsletter' );

if( $newsletter_content_class )
	$tpl->setVariable( 'newsletter_content_class_id', $newsletter_content_class->ID );


$viewParameters = array( 'offset' => $Params['Offset'] );

$tpl->setVariable( 'node', $node );
$tpl->setVariable( 'set_limit', $limit );
$tpl->setVariable( 'view_parameters', $viewParameters );

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/newsletters/index.tpl' ),
    'path'    => array(
        array( 
			'url' => 'jaj_newsletter/index', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
		),
		array(
			'url' => false, 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletters' ),		
		)
    )
);

?>