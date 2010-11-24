<?php
$Module = $Params['Module'];

$ListID = $Params['ListID'];

$list = jajNewsletterSubscriptionList::fetch( $ListID );

if ( !is_object( $list ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

$tpl = eZTemplate::factory();
$template = 'design:jaj_newsletter/subscription/new.tpl';

if ( $Module->isCurrentAction( 'Subscribe' ) )
{
	$name = trim( $Module->actionParameter( 'SubscriptionName' ) );
	$email = trim( $Module->actionParameter( 'SubscriptionEmail' ) );
	
	$messages = array();
	
	$subscription = jajNewsletterSubscription::addSubscription( $email, $name, $list );	
	
	if( $subscription->attribute('state') == 'deleted' )
	{
		$template = 'design:jaj_newsletter/subscription/deny.tpl';
	}
	else if( !$subscription->isValid(&$messages) )
	{
		$tpl->setVariable( 'is_valid', false );
    	$tpl->setVariable( 'validation_messages', $messages );
	}
	else
	{
		try
		{
			if( $subscription->State == 'unconfirmed' ) 
			{
				$subscription->sendConfirmationMail( $list );
			}				
			$template = 'design:jaj_newsletter/subscription/success.tpl';	
		} 
		catch (Exception $e) {
			$tpl->setVariable( 'is_error', true );
			$tpl->setVariable( 'error_messages', explode( '\n', $e->getMessage() ) );
		}		
	}
}


$tpl->setVariable( 'list', $list );
$tpl->setVariable( 'subscription', $subscription );

$Result = array(
    'path'    => array(
        	array( 
				'url' => false, 
				'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
			),
			array(
				'url' => false, 
				'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Subscribe' )
			)
    ),
    'content' => $tpl->fetch( $template )
);

?>