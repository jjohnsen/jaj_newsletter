<?php

$Module = $Params[ 'Module' ];

if ( $Module->isCurrentAction( 'NewList' ) )
{
	$Module->redirectTo( $Module->functionURI( "list_edit" ) );
	return;
}

$tpl = eZTemplate::factory();

$lists = jajNewsletterSubscriptionList::fetchByOffset();

$tpl->setVariable( 'lists', $lists );

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/lists/index.tpl' ),
    'path'    => array(
        array( 
			'url' => 'jaj_newsletter/index', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
		),
		array(
			'url' => false, 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Subscription Lists' ),		
		)
    )
);