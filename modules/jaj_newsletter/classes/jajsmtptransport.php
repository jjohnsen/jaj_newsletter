<?php

class jajSmtpTransport
{

	static public function send($to, $subject, $body, $options = array() ) {
	
    	$siteINI = eZINI::instance( 'site.ini' );
    	$i18nINI = eZINI::instance( 'i18n.ini' ); 	

    	$transport = $siteINI->variable( 'MailSettings', 'Transport' );
    	$charset = $i18nINI->variable( 'CharacterSettings', 'Charset' );
		$emailSender = $siteINI->variable( 'MailSettings', 'EmailSender' );
	
		if( !$emailSender )
    		$emailSender = $siteINI->variable( 'MailSettings', 'AdminEmail' );
		
		if($transport == 'SMTP')
	    {	    	
	    	$mailTransport = new ezcMailSmtpTransport(
		    		$siteINI->variable( 'MailSettings', 'TransportServer' ),
		    		$siteINI->variable( 'MailSettings', 'TransportUser' ),
		    		$siteINI->variable( 'MailSettings', 'TransportPassword' ),
		    		$siteINI->variable( 'MailSettings', 'TransportPort' )		    		
	    	);
	    }
	    else
		{
			eZDebug::writeError( 'Only SMTP Transport supported', 'jajNewsletterSubscription::sendConfirmationMail' );
			throw new Exception( 'Only SMTP Transport supported' );
		}
		
		$mail = new ezcMailComposer();
		$mail->charset = $charset;
		$mail->subjectCharset = $charset;
		
		$mail->subject = $subject;
		$mail->htmlText = $body;
		
		$mail->from = ezcMailTools::parseEmailAddress( $emailSender, $charset );
		$mail->addTo( new ezcMailAddress( $to, '', $charset ) );
		
		$mail->build();
		
		$mailTransport->send( $mail );		
	}
	
	static public function charset() {
		$i18nINI = eZINI::instance( 'i18n.ini' );
		return $i18nINI->variable( 'CharacterSettings', 'Charset' );
	}
	
	static public function mailTransport() {
    	$siteINI = eZINI::instance( 'site.ini' ); 	

    	$transport = $siteINI->variable( 'MailSettings', 'Transport' );
				
		if($transport == 'SMTP')
	    {	    	
	    	$mailTransport = new ezcMailSmtpTransport(
		    		$siteINI->variable( 'MailSettings', 'TransportServer' ),
		    		$siteINI->variable( 'MailSettings', 'TransportUser' ),
		    		$siteINI->variable( 'MailSettings', 'TransportPassword' ),
		    		$siteINI->variable( 'MailSettings', 'TransportPort' )		    		
	    	);
	    }
	    else
		{
			eZDebug::writeError( 'Only SMTP Transport supported', 'jajSmtpTransport::mailTransport' );
			throw new Exception( 'Only SMTP Transport supported' );
		}
		
		return $mailTransport;
	}
}

?>
