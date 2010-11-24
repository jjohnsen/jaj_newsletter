<?php
	$Module = $Params[ 'Module' ];
	$tpl 	= eZTemplate::factory();
	$http	= eZHTTPTool::instance();
	
	$newsletter_id = $Params['NewsletterID'];
	$node = eZContentObject::fetch( $newsletter_id );

	if ( !$node || !$node->canRead() )
		return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );
	
	if ( $Module->isCurrentAction( 'SendNewsletter' ) )
	{
		$result = jajNewsletterDelivery::generateDeliveryForNewsletter( $node );
		$http->setSessionVariable( 'NewsletterSent', $result );
	}
	
	if ( $Module->isCurrentAction( 'Cancel' ) || $Module->isCurrentAction( 'SendNewsletter' ) )
		return $Module->redirectTo( $Module->functionURI( "newsletter" ) . "/" . $node->mainNodeID() );
	
	$tpl->setVariable( 'node', $node );
	
	// TODO: Fix with own counter function
	$unique_recipients = count( jajNewsletterSubscription::fetchUniqueForNewsletterId( $node->ID, false ) );
	$tpl->setVariable( 'unique_recipients', $unique_recipients );
	
	$Result = array(
    	'content' => $tpl->fetch( 'design:jaj_newsletter/newsletters/send.tpl' ),
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
				'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Send Newsletter' )
			)
    	)
	);

?>