<?php

$Module = $Params[ 'Module' ];
$ListID = $Params['ListID'];

$list = jajNewsletterSubscriptionList::fetch( $ListID );

if ( !is_object( $list ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

if ( $Module->isCurrentAction( 'Cancel' ) )
{
	return $Module->redirectTo( $Module->functionURI( "list" ) . "/" . $ListID );
}

$tpl = eZTemplate::factory();
$tpl->setVariable( 'list', $list );

if ( $Module->isCurrentAction( 'Store' ) ) 
{
	$subscribers = $Module->actionParameter( 'SubscribersList' );
	$messages = array();
	$list->createSubscribersFromList( $subscribers, $messages );
	$tpl->setVariable( 'subscribers', $subscribers );
	$tpl->setVariable( 'messages', $messages );
}

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/lists/add.tpl' ),
    'path'    => array(
        array( 
			'url' => 'jaj_newsletter/index', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
		),
		array(
			'url' => 'jaj_newsletter/lists', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Subscription Lists' ),		
		),
		array(
			'url' => 'jaj_newsletter/list/' . $list->attribute( 'id' ),
			'text' => $list->attribute( 'name' )
		),
		array(
			'url' => false,
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Add subscribers' )
		)		
    )
);

?>