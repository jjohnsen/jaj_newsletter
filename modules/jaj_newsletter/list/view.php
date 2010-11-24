<?php
$Module = $Params[ 'Module' ];

$ListID = $Params['ListID'];
$list 	= jajNewsletterSubscriptionList::fetch( $ListID );

if ( !is_object( $list ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

if ( $Module->hasActionParameter( 'SubscriberUUIDArray' ) )
{
	$UUIDList = $Module->actionParameter( 'SubscriberUUIDArray' );
	$user_id  = eZUser::currentUser()->attribute( "contentobject_id" );
	
	foreach ($UUIDList as $uuid )
	{
		if( $Module->isCurrentAction( 'DeleteSubscribers' ) )
		{
			jajNewsletterSubscription::deleteByUUID( $uuid, $user_id ); 	
		}
		else if( $Module->isCurrentAction( 'UnsubscribeSubscribers' ) )
		{
			jajNewsletterSubscription::unsubscribeByUUID( $uuid, $user_id ); 	
		}
		else if( $Module->isCurrentAction( 'UndeleteSubscribers' ) )
		{
			jajNewsletterSubscription::undeleteByUUID( $uuid, $user_id ); 	
		}		
	}
}
else if ( $Module->isCurrentAction( 'AddSubscribers' ) )
{
	return $Module->redirectTo( $Module->functionURI( "list_add" ) . "/" . $ListID );
}

switch( eZPreferences::value( 'admin_jaj_newsletter_subscription_list_limit' ) )
{
	case '25': { $limit = 25; } break;
	case '50': { $limit = 50; } break;
	default:  { $limit = 10; } break;
}

$offset = $Params['Offset'];

$tpl = eZTemplate::factory();

$ViewState 			= $Params['ViewState'];
$SubscriptionStates	= jajNewsletterSubscription::states();

if( !in_array( $ViewState, $SubscriptionStates ) )
{
	$ViewState = $SubscriptionStates[0];
}

for( $i=0; $i < count($SubscriptionStates); $i++ ) {
	$id = $SubscriptionStates[$i];

	$SubscriptionStates[$i] = array(
		'id' 		=> $id,
		'name' 		=> ucwords( $id ),
		'count' 	=> $list->fetchSubscribersCount( $id ),
		'selected' 	=> ( $id == $ViewState ),
		'first' 	=> ( $i == 0 )
	);
	
	if( $id==$ViewState )
	{
		$ItemCount = $SubscriptionStates[$i]['count'];
	}
}

$subscribers = $list->fetchSubscribersByState( $ViewState, $limit, $offset );

$viewParameters = array( 'offset' => $offset );

$tpl->setVariable( 'view_state', $ViewState );
$tpl->setVariable( 'list', $list );
$tpl->setVariable( 'subscriber_states', $SubscriptionStates );
$tpl->setVariable( 'subscribers', $subscribers );
$tpl->setVariable( 'set_limit', $limit );
$tpl->setVariable( 'offset', $offset );
$tpl->setVariable( 'item_count', $ItemCount );
$tpl->setVariable( 'view_parameters', $viewParameters );

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/lists/view.tpl' ),
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
			'url' => false,
			'text' => $list->attribute( 'name' )
		)
    )
);