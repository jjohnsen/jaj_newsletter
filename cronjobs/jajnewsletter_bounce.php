<?php
	require_once("extension/jaj_newsletter/lib/bounce_handler/bounce_driver.class.php");
	
	$server = "zmail-01.hikt.no";
	$username = "ikke-svar-hrnf@hikt-demo.no";
	$password = "hrnf_ikke_svar";
	
	
	
	$bouncehandler = new Bouncehandler();
	
	$pop3 = new ezcMailPop3Transport( $server );
	$pop3->authenticate( $username, $password );
	
	$pop3->status( $num, $size );

	$cli->output( 'Bounce messages to check: ' . $num );	
	
	$messages = $pop3->listMessages(); 
	
	foreach( $messages as $index => $size )
	{
		$set = $pop3->fetchByMessageNr( $index );
		
		do
		{
			$raw_message = "";
			$line = "";
			while ( ( $line = $set->getNextLine() ) !== null )
			{
				$raw_message .= $line;
			}
			$result = $bouncehandler->get_the_facts($raw_message);
			$result = $result[0];
			
			$status = $result['status'];
			$action = $result['action'];
			$recipient = trim( $result['recipient'] );
			
			if( !in_array( $action, array( "delayed", "failed", "autoreply" ) ) )
			{
				$cli->output( "Message index: ${index}, unknown action: ${action}, skipping...");
				continue;
			}
			
			if( $action == 'delayed' || $action == 'autoreply' )
			{
				$cli->output( "Deleting message: ${index}, action: ${action}" );
				$pop3->delete( $index );
				continue;				
			}
			
			if( $action == 'failed' )
			{
				$cli->output( "Message index: ${index}, status: ${status}, action: ${action}, recipient: ${recipient}" );
				$subscriptions = jajNewsletterSubscription::fetchActiveByEmail( $recipient );
				foreach( $subscriptions as $subscription )
				{
					$state = $subscription->attribute("state");
					if( $state == "active" )
					{
						$cli->output( "Found matching subscription: " . $subscription->attribute("uuid") . " changing status from: " . $subscription->attribute("state") . " to: bounced");
						
						
						$subscription->setAttribute( 'state', 'bounced' );
						$subscription->setAttribute( 'bounced', time() );
						$subscription->setAttribute( 'modified', time() );
						$subscription->store();
					}
					
				}
				$pop3->delete( $index );
			}
		} while ( $set->nextMail() );
	}
?>
