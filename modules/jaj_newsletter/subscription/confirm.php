<?php

$Module = $Params['Module'];
$UUID = $Params['UUID'];

$valid = true;

$subscription = jajNewsletterSubscription::fetchByUUID( $UUID );
$list = null;

if ( !is_object( $subscription ) )
{
	$valid = false;
}
else
{
	$list = $subscription->subscriptionList();
	if( !is_object( $list ) )
	{
		$valid = false;	
	}
	else
	{
		$valid = $subscription->confirm();
	}
}

$tpl = eZTemplate::factory();
$template = 'design:jaj_newsletter/subscription/confirm.tpl';

$tpl->setVariable( 'list', $list );
$tpl->setVariable( 'subscription', $subscription );
$tpl->setVariable( 'valid', $valid );

$Result = array(
    'path' => $path,
    'content' => $tpl->fetch( $template )
);

?>

