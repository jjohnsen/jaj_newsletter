<?php
	$Module 	= $Params['Module'];
	$tpl 		= eZTemplate::factory();
	$template 	= 'design:jaj_newsletter/subscription/unsubscribe.tpl';
	
	$uuid = $Params['UUID'];
	
	$subscription = jajNewsletterSubscription::fetchByUUID($uuid);
	
	if( !is_object( $subscription ) )
	{
    	return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
	}
	
	if ( $Module->isCurrentAction( 'ConfirmUnsubscribe' ) )
	{
		if( $subscription->attribute("state") == "active" )
		{
			$result = jajNewsletterSubscription::unsubscribeByUUID( $subscription->attribute("uuid") );
		}
	}

	
	$subscriptions = jajNewsletterSubscription::fetchActiveByEmail( $subscription->attribute('email') );
	
	$tpl->setVariable( 'subscription', $subscription );
	$tpl->setVariable( 'subscriptions', $subscriptions );
	
	$Result = array(
    	'path'    => array(
        	array( 
				'url' => false, 
				'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
			),
			array(
				'url' => false, 
				'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Unsubscribe' )
			)
    	),

    	'content' => $tpl->fetch( $template )
	);
?>