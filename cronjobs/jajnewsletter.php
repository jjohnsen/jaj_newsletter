<?php
	// Fetch settings
	$newsletter_ini = eZINI::instance( 'jaj_newsletter.ini' );
	$site_ini 		= eZINI::instance( 'site.ini' );
	
	$root_node_id 	= $newsletter_ini->variable( 'NewsletterSettings', 'RootFolderNodeId' );
	$batch_limit 	= $newsletter_ini->variable( 'NewsletterDelivery', 'BatchLimit' );
	$site_url 		= $site_ini->variable( 'SiteSettings', 'SiteURL' );
	
	$mail_transport = jajSmtpTransport::mailTransport();
	$charset		= jajSmtpTransport::charset();
	$from_email		= new ezcMailAddress( 
		$newsletter_ini->variable( 'NewsletterSettings', 'FromEmail' ),
		$newsletter_ini->variable( 'NewsletterSettings', 'FromName' ),
		$charset
	);
	$reply_email		= new ezcMailAddress( 
		$newsletter_ini->variable( 'NewsletterSettings', 'ReplyEmail' ), '', $charset
	);
	
	if( !$batch_limit )
		$batch_limit = 200;
	
	$pendingNewsletters = eZContentObjectTreeNode::subTreeByNodeID( array(
		'Limit' 			=> 10,
		'ClassFilterType' 	=> 'include',
		'ClassFilterArray' 	=> array( 'jaj_newsletter' ),
		'AttributeFilter' 	=> array(
			array( 'jaj_newsletter/status', '=', 'in progress' )
		)
	), $root_node_id );
	
	foreach( $pendingNewsletters as $newsletter)
	{
		$cli->output( 'Delivering newsletter: ' . $newsletter->getName() . ' (ContentObjectID: ' . $newsletter->ContentObjectID . ')' );
		$cli->output( 'Batch limit left: ' . $batch_limit );
		
		$object_id 		= $newsletter->ContentObjectID;
		$url_alias		= $newsletter->urlAlias();
		$url_newsletter = "http://" . $site_url . "/" . $url_alias . "/(generate)/nl/(uuid)/";
		$data_map 		= $newsletter->DataMap();
		$subject 		= $data_map['subject']->toString();
		
		$deliveries 	= jajNewsletterDelivery::fetchDeliveriesByContentobjectIDAndState( $object_id, 'pending', $batch_limit, 0, true );

		foreach( $deliveries as $delivery )
		{
			$batch_limit--;
			$cli->output( 'Generating mail for: ' . $delivery->attribute('email') );
			
			// Sanity check
			if( $delivery->attribute('sent') || $delivery->attribute('state') != 'pending' ) {
				$cli->output( 'Looks like this has been sent before. Bailing...' );
				continue;
			}
			
			// Newsletter URL
			$url 	= $url_newsletter . $delivery->attribute('uuid');
			
			// Genereate HTML mail
			$cmd = "/usr/local/bin/premailer -r --mode html " . escapeshellarg($url) . " 2>&1";
			
			$return = exec( $cmd, $output, $return_var );
			$html = implode("\n", $output);
			
			if( $return_var != 0) {
				$cli->output( "Error executing command: ${cmd}");
				$cli->output( $output );
				continue;	
			}
			unset($output);
			
			// Genereate plain text mail
			$cmd = "/usr/local/bin/premailer -r --mode txt " . escapeshellarg($url) . "2>&1";
			
			$return = exec( $cmd, $output, $return_var );
			$text = implode("\n", $output);
			
			if( $return_var != 0) {
				$cli->output( "Error executing command: ${cmd}");
				$cli->output( $output );
				continue;	
			}
			unset($output);
			
			// Send mail
			$mail = new ezcMailComposer();
			$mail->charset = $charset;
			$mail->subjectCharset = $charset;
		
			$mail->subject = $subject;
			$mail->htmlText = $html;
			$mail->plainText = $text;
		
			$mail->from = $from_email;
			$mail->addTo( new ezcMailAddress( $delivery->attribute('email'), '', $charset ) );
			//$mail->addTo( new ezcMailAddress( 'jan.age.johnsen@gmail.com', '', $charset ) );
			$mail->setHeader( "Reply-To", $reply_email->__toString(), $charset );
			
			$cli->output( 'Building mail for: ' . $delivery->attribute('email') );
			$mail->build();			
			
			$cli->output( 'Sending mail to: ' . $delivery->attribute('email') );
			try {
				$mail_transport->send( $mail );
			}
			catch (Exception $e) {
				$cli->output( 'Error sending mail: ' . $e->getMessage() );
			}

			$delivery->setAttribute('state', 'sent');
			$delivery->setAttribute('sent', time());
			$delivery->store();			
		}
			
		
		// Check if remaining deliveries
		$deliveries_count = jajNewsletterDelivery::fetchDeliveriesByContentobjectIdCount( $object_id, 'pending' );		
		if( $deliveries_count == 0 )
		{
			$cli->output( 'Pending deliveries: ' . $deliveries_count . ', archiving newsletter' );
			$status = $data_map['status'];
			$status->fromString("archive");
			$status->store();
		}
		
		if( $batch_limit <= 0) {
			$cli->output( 'Batch limit reached. Stopping' );
			break;
		}
		
	}
	//$cli->output( 'Testing... ' );
	exec('ls');
?>