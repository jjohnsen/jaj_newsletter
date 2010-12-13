<?php
$Module = $Params[ 'Module' ];
$http	= eZHTTPTool::instance();
$tpl	= eZTemplate::factory();

$newsletter_node_id = $Params['NewsletterNodeID'];
$node = eZContentObject::fetchByNodeID( $newsletter_node_id );

if ( !$node || !$node->canRead() )
	return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

$tabs = array( 
	'details' => 'Details',
	'preview_html' => 'Preview HTML',
	'preview_text' => 'Preview Text',
	'activity' => "Activity"
);

$selected_tab = ( array_key_exists( $Params['Tab'], $tabs) ? $Params['Tab'] : 'details' ); 
$recipients_lists = jajNewsletterRecipientsList::fetchByContentObjectID( $node->ID );
$error_strings = array();

if( $http->hasSessionVariable( 'PreviewInvalidReceiver' ) ) {
	$error_strings[] = ezpI18n::tr( 'design/admin/jaj_newsletter/newsletter', 'The email address of the preview receiver is not valid' );
	$http->removeSessionVariable( 'PreviewInvalidReceiver' );
}

if( $http->hasSessionVariable( 'PreviewSendEmailFailed' ) ) {
	$error_strings[] = ezpI18n::tr( 'design/admin/jaj_newsletter/newsletter', $http->sessionVariable( 'PreviewSendEmailFailed' ) );
	$http->removeSessionVariable( 'PreviewSendEmailFailed' );
}

if( $http->hasSessionVariable( 'PreviewEmailSent' ) ) {
	$feedback_strings[] = ezpI18n::tr( 'design/admin/jaj_newsletter/newsletter', 'Preview e-mail was sent to: %email', null, array('%email' => $http->sessionVariable( 'PreviewEmailSent' ) ) );
	$http->removeSessionVariable( 'PreviewEmailSent' );
}

if( $http->hasSessionVariable( 'NewsletterSent' ) ) {
	$feedback_strings[] = ezpI18n::tr( 'design/admin/jaj_newsletter/newsletter', 'Newsletter delivery started for %count recipients', null, array('%count' => $http->sessionVariable( 'NewsletterSent' ) ) );
	$http->removeSessionVariable( 'NewsletterSent' );
}

$offset = $Params['Offset'];
switch( eZPreferences::value( 'admin_jaj_newsletter_newsletter_view_limit' ) )
{
	case '25': { $limit = 25; } break;
	case '50': { $limit = 50; } break;
	default:  { $limit = 10; } break;
}
$view_parameters = array( 'offset' => $offset );

$deliveries = jajNewsletterDelivery::fetchDeliveriesByContentobjectID( $node->ID, $limit, $offset );
$deliveries_count = jajNewsletterDelivery::fetchDeliveriesByContentobjectIdCount( $node->ID );

$newsletter_ini = eZINI::instance( 'jaj_newsletter.ini' );
$from_email   = $newsletter_ini->variable( 'NewsletterSettings', 'FromEmail' );
$from_name    = $newsletter_ini->variable( 'NewsletterSettings', 'FromName' );
$reply_email  = $newsletter_ini->variable( 'NewsletterSettings', 'ReplyEmail' );

$tpl->setVariable( 'node', $node );
$tpl->setVariable( 'recipients_lists', $recipients_lists );
$tpl->setVariable( 'tabs', $tabs );
$tpl->setVariable( 'selected_tab', $selected_tab );
$tpl->setVariable( 'error_strings', $error_strings );
$tpl->setVariable( 'feedback_strings', $feedback_strings );
$tpl->setVariable( 'total_active_recipients', jajNewsletterSubscription::countByRecipientsLists( $recipients_lists, 'active' ) );
$tpl->setVariable( 'total_recipients', jajNewsletterSubscription::countByRecipientsLists( $recipients_lists ) );
$tpl->setVariable( 'from_email', $from_email );
$tpl->setVariable( 'from_name', $from_name );
$tpl->setVariable( 'reply_email', $reply_email );
$tpl->setVariable( 'deliveries', $deliveries );
$tpl->setVariable( 'deliveries_count', $deliveries_count );
$tpl->setVariable( 'set_limit', $limit );
$tpl->setVariable( 'offset', $offset );
$tpl->setVariable( 'view_parameters', $view_parameters );

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/newsletters/view.tpl' ),
    'path'    => array(
        array( 
			'url' => 'jaj_newsletter/index', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
		),
		array(
			'url' => 'jaj_newsletter/newsletters', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletters' ),		
		),
		array(
			'url' => false,
			'text' => $node->attribute( 'name' )
		)
    )
);

?>