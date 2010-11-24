<?php
	$Module = $Params[ 'Module' ];
	$http	= eZHTTPTool::instance();
	
	$newsletter_node_id = $Params['NewsletterNodeID'];
	$node = eZContentObject::fetchByNodeID( $newsletter_node_id );

	if ( !$node || !$node->canRead() )
		return $Module->handleError( eZError::KERNEL_NOT_AVAILABLE, 'kernel' );

	$mode = ( $Params['Mode'] == "text" ? "txt" : "html" );

    $ini = eZINI::instance( 'site.ini' );
    $site_url = $ini->variable( 'SiteSettings', 'SiteURL' );
    	
    $url = "http://" . $site_url . "/" . $node->mainNode()->urlAlias() . "/(preview)/nl";
    $cmd = "/usr/local/bin/premailer -r --mode ${mode} " . escapeshellarg($url) . " 2>&1";
    
	exec(  $cmd, $output, $return_var );
	
	$output = implode("\n", $output);
	
	if( $return_var != 0)
		$output = "Error executing command: ${cmd}\n\n${output}";
	
	$content = ( $mode == "txt" ? nl2br($output) : $output );
	
	if ( $Module->isCurrentAction( 'SendPreview' ) ) {
		$email = $Module->actionParameter( 'EmailAddress' );
		
		if( !eZMail::validate( $email ) ) {
			$http->setSessionVariable( 'PreviewInvalidReceiver', $email );
		} else {
			try {
				$data_map = $node->DataMap();
				$subject = $data_map['subject']->toString();
				jajSmtpTransport::send( $email, $subject, $output );
				$http->setSessionVariable( 'PreviewEmailSent', $email );
			}
			catch (Exception $e) {
				$http->setSessionVariable( 'PreviewSendEmailFailed', $e->getMessage() );
			}
		}

		return $Module->redirectTo( $Module->functionURI( "newsletter" ) . "/" . $node->mainNodeID() );
	}
	
	echo $content;
	eZExecution::cleanExit();
?>