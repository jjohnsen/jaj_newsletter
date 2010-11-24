<?php

class jajNewsletterEventType extends eZNotificationEventType
{
    const NOTIFICATION_TYPE_STRING = 'jaj_newsletter';

    /*!
     Constructor
    */
    function eZPublishType()
    {
        $this->eZNotificationEventType( self::NOTIFICATION_TYPE_STRING );
    }

    function initializeEvent( $event, $params )
    {
    	$event->setAttribute( 'data_int1', $params['list_id'] );
    	$event->setAttribute( 'data_text1', $params['action'] );
    	$event->setAttribute( 'data_text2', $params['uuid'] );    	
    }

    function eventContent( $event )
    {
        return eZContentObjectVersion::fetchVersion( $event->attribute( 'data_int2' ), $event->attribute( 'data_int1' ) );
    }
}

eZNotificationEventType::register( jajNewsletterEventType::NOTIFICATION_TYPE_STRING, 'jajNewsletterEventType' );

?>
