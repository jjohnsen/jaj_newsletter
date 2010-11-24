<?php

$Module = $Params[ 'Module' ];

$tpl = eZTemplate::factory();

$newsletter_id = $Params['NewsletterID'];
$node = eZContentObject::fetch( $newsletter_id );

if ( !$node || !$node->canRead() )
	return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

// TODO: Rewrite
if ( $Module->isCurrentAction( 'StoreRecipients' ) ) 
{
	
	// Remove all associations 
	$recipients_lists = jajNewsletterRecipientsList::fetchByContentObjectID( $newsletter_id );

	foreach( $recipients_lists as $list )
    {
    	$list->remove();
    }
	
	// And add the selected ones
	if( $Module->hasActionParameter( 'SubscriptionListIdArray' ) )
	{
		$subscription_list_ids = $Module->actionParameter( 'SubscriptionListIdArray' );
		foreach( $subscription_list_ids as $list_id )
    	{
    		$recipients_list = jajNewsletterRecipientsList::create( $newsletter_id, $list_id );
    		$recipients_list->store();
    	}
    }
}

if( $Module->isCurrentAction( 'RemoveRecipientsList' ) )
{
	$recipients_list = jajNewsletterRecipientsList::fetch( $newsletter_id, $Module->actionParameter( 'SubscriptionListID' ) );
	if ( is_object( $recipients_list ) )
		$recipients_list->remove();
}

if ( $Module->isCurrentAction( 'Cancel' ) || $Module->isCurrentAction( 'StoreRecipients' ) || $Module->isCurrentAction( 'RemoveRecipientsList' ) )
	return $Module->redirectTo( $Module->functionURI( "newsletter" ) . "/" . $node->mainNodeID() );


$lists = jajNewsletterSubscriptionList::fetchByOffset();
$recipients_lists = jajNewsletterRecipientsList::fetchByContentObjectID( $newsletter_id, false );

$active_list_ids = array();
foreach( $recipients_lists as $list )
{
	array_push ( $active_list_ids , $list['subscription_list_id'] );
}

$tpl->setVariable( 'node', $node );
$tpl->setVariable( 'lists', $lists );
$tpl->setVariable( 'active_list_ids', $active_list_ids );


$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/newsletters/add_recipients.tpl' ),
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
			'url' => 'jaj_newsletter/newsletter/' . $node->mainNodeID(),
			'text' => $node->attribute( 'name' )
		),
		array(
			'url' => false,
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Add Recipients' )
		)
    )
);

?>