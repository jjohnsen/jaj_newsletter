<?php
	$object_id 	= $Params['object_id'];
	$uuid		= $Params['uuid'];
	$operation  = $Params['operation'];
	
	$delivery 	= jajNewsletterDelivery::fetchByObjectIdAndUUID( $object_id, $uuid );
	
	if( is_object($delivery) )
	{
		$delivery->markAsOpened();
		if( $operation == 'view' )
			$delivery->markAsViewed();
	}			
	$image = 'extension/jaj_newsletter/design/standard/images/logo.gif';
	
	if( !file_exists($image) )
    {
        eZDebug::writeEror( "Image for tracking doesn't exist", 'jaj_newsletter::newsletter::track' );
        return;
    }
	
    ob_clean();

    header( 'Pragma: ' );
    header( 'Cache-Control: ' );
    /* Set cache time out to 10 seconds, this should be good enough to work around an IE bug */
    header( "Expires: ". gmdate( 'D, d M Y H:i:s', time() + 10 ) . ' GMT' );
    header( 'X-Powered-By: eZ Publish' );

    header( 'Content-Length: '. filesize($image) );
    header( 'Content-Type: image/gif' );
    header( 'Content-Transfer-Encoding: binary' );
    header( 'Accept-Ranges: bytes' );

    ob_end_clean();
	
    $fp = @fopen( $image, 'r' );
    @fpassthru( $fp );
    fclose( $fp );
	
    eZExecution::cleanExit();
?>