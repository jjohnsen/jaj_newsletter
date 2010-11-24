<?php

class jajNewsletterSubscription extends eZPersistentObject
{
	const MAX_EMAIL_LENGTH = 150;
	const MAX_NAME_LENGTH = 100;
	
    function __construct( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    public static function definition()
    {
        static $definition = array( 
        						"fields" => array(         							
        							"uuid" => array( 
        								"name" => "UUID",
                                        "datatype" => "string",
                                        "required" => true
                                    ),
                                    "name" => array( 
                                    	"name" => "Name",
                                        "datatype" => "string",
                                        "required" => false,
                                        "max_length" => self::MAX_NAME_LENGTH
                                    ),
                                    "email" => array( 
                                    	"name" => "Email",
                                        "datatype" => "string",
                                        "required" => true,
                                        "max_length" => self::MAX_EMAIL_LENGTH
                                    ),
                                    "state" => array( 
                                    	"name" => "State",
                                        "datatype" => "string",
                                        "required" => true,
                                        "max_length" => 12
                                    ),                                                                             
                                    "creator_id" => array( 
                                    	'name' => "CreatorID",
                                        'datatype' => 'integer',
                                        'default' => 0,
                                        'required' => true,
                                        'foreign_class' => 'eZUser',
                                        'foreign_attribute' => 'contentobject_id',
                                        'multiplicity' => '1..*' 
                                    ),
                                    "modifier_id" => array( 
                                    	'name' => "ModifierID",
                                        'datatype' => 'integer',
                                        'default' => 0,
                                        'required' => true,
                                        'foreign_class' => 'eZUser',
                                        'foreign_attribute' => 'contentobject_id',
                                        'multiplicity' => '1..*' 
                                    ),
									"created" => array( 
											'name' => "Created",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),
                                    "modified" => array( 
                                    		'name' => "Modified",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),
                                    "subscription_list_id" => array( 
                                    	'name' => "SubscriptionListID",
                                        'datatype' => 'integer',
                                        'default' => 0,
                                        'required' => true,
                                        'foreign_class' => 'jajNewsletterSubscriptionList',
                                        'foreign_attribute' => 'id',
                                        'multiplicity' => '1..*' 
                                    ),
                                    "subscribed" => array( 
                                    		'name' => "Subscribed",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),
                                    "confirmed" => array( 
                                    		'name' => "Confirmed",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),                                    
                                    "unsubscribed" => array( 
                                    		'name' => "Unsubscribed",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),
                                    "bounced" => array( 
                                    		'name' => "Bounced",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),
                                    "bounce_count" => array( 
                                    		'name' => "BounceCount",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),                                                                                                        
                                    "deleted" => array( 
                                    		'name' => "Deleted",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true 
                                    ),                                                                                                    
                                ),                                
                      			"keys" => array( "uuid" ),
                      			"function_attributes" => array(
                      				'creator' => 'creator',
                      				'modifier' => 'modifier',
                      				'subscription_list' => 'subscriptionList'
                      			),
                      			//"increment_key" => "uuid",
                      			"class_name" => "jajNewsletterSubscription",
                      			"sort" => array( "identifier" => "asc" ),
                      			"name" => "jaj_newsletter_subscription" );
        return $definition;
    }
    
    static function UUID( )
	{
		// http://gist.github.com/365502
	    // Time based PHP Unique ID
		$uid = uniqid(NULL, TRUE);
		// Random SHA1 hash
		$rawid = strtoupper(sha1(uniqid(rand(), true)));
		// Produce the results
		$result = substr($uid, 6, 8);
		$result .= substr($uid, 0, 4);
		$result .= substr(sha1(substr($uid, 3, 3)), 0, 4);
		$result .= substr(sha1(substr(time(), 3, 4)), 0, 4);
		$result .= strtolower(substr($rawid, 10, 12));
		// Return the result
		return $result;
	}
	
	static function states()
	{
		return array("active", "unconfirmed", "unsubscribed", "bounced", "deleted");
	}
	
	//static function countBy
	static function countByRecipientsLists( $lists, $status = array() )
	{	
		$list_ids 	= array();
		
		foreach( $lists as $list )
		{
			if( is_a( $list, 'jajNewsletterRecipientsList' ) )
				array_push( $list_ids, $list->SubscriptionListID );
		}
		
		if( count($list_ids) )
		{
			$conditions = array( 'subscription_list_id' => array( $list_ids ) );

	    	if( is_string($status) )
    			$status = array( $status );
	    	if( is_array( $status ) )
    			$status = array_intersect( jajNewsletterSubscription::states(), $status);
    	
			if( count($status) )
				$conditions['jaj_newsletter_subscription.state'] = array( $status );
			
			return eZPersistentObject::count( jajNewsletterSubscription::definition(), $conditions, "email" );
		}
		
		return 0;
	}

    public static function fetchNewsletterRecipientsCount( $object_id, $status=array() )
    {
		$conds = array( 
			'jaj_newsletter_recipients_list.contentobject_id' => $object_id
		);
    
    	if( is_string($status) )
    		$status = array( $status );
    	if( is_array( $status ) )
    		$status = array_intersect( jajNewsletterSubscription::states(), $status);
    	
		if( count($status) )
			$conds['jaj_newsletter_subscription.state'] = array( $status );
		
		$field = 'jaj_newsletter_subscription.email';
		$custom_fields = array( array( 'operation' => 'COUNT( DISTINCT ' . $field . ' )', 'name' => 'row_count' ) );
		$custom_tables = array( 'jaj_newsletter_subscription_list', 'jaj_newsletter_recipients_list' );
		$custom_conds = ' AND jaj_newsletter_subscription.subscription_list_id = jaj_newsletter_subscription_list.id' 
					  . ' AND jaj_newsletter_recipients_list.subscription_list_id = jaj_newsletter_subscription_list.id';
					  
		$rows = eZPersistentObject::fetchObjectList( 
			jajNewsletterSubscription::definition(), 
			array(), // field_filters
			$conds, 
			array(), // sorts
			null, // limit
			false, // asObject
			false, // grouping 
			$custom_fields, 
			$custom_tables, 
			$custom_conds
		);
  	
    	return array( 'result' => $rows[0]['row_count'] );
    }
    
    public static function fetchUniqueForNewsletterId( $contentobject_id, $asObject=true )
    {
    	$db = eZDB::instance();
    	
    	$query = "SELECT jaj_newsletter_subscription.*
    		   		FROM jaj_newsletter_subscription,
    		   			 jaj_newsletter_subscription_list,
    		   			 jaj_newsletter_recipients_list
    		   		WHERE
    		   			jaj_newsletter_subscription.subscription_list_id = jaj_newsletter_subscription_list.id
    		   		AND
    		   			jaj_newsletter_recipients_list.subscription_list_id = jaj_newsletter_subscription_list.id
    		   		AND
    		   			jaj_newsletter_recipients_list.contentobject_id = " . $contentobject_id . "
    		   		AND
    		   			jaj_newsletter_subscription.state = 'active'
    		   		AND
    		   			jaj_newsletter_subscription.email NOT IN (
    		   				SELECT email FROM jaj_newsletter_delivery WHERE contentobject_id = " . $contentobject_id . "
    		   			)
    		   		GROUP BY jaj_newsletter_subscription.email
    		   		
    		   	";
    		   		
    	$subscriptionArray = $db->arrayQuery( $query );
    	
    	if( $asObject )
    	{
    		$subscribers = array();
    		foreach ( $subscriptionArray as $subscription )
 				$subscribers[] = new jajNewsletterSubscription( $subscription );
    		return $subscribers;
    	}
    	
    	return $subscriptionArray;
    }

	static function fetchActiveByEmail( $email , $asObject = true )
    {
        return eZPersistentObject::fetchObjectList( jajNewsletterSubscription::definition(),			
    								null,
    								array(
	    								'email' => $email,
		    							'state' => 'active'	
    								),
    								array(),
    								array(),
	    							$asObject,
	    							false
	    );
    } 
    	    
	static function fetchByUUID( $uuid , $asObject = true )
    {
        return eZPersistentObject::fetchObject( jajNewsletterSubscription::definition(),
                                                null,
                                                array( 'uuid' => $uuid ),
                                                $asObject );
    } 

    function deleteByUUID( $uuid, $user_id ) {
    	$subscriber = self::fetchByUUID( $uuid );

    	if( !$subscriber || $subscriber->attribute('state') != 'active' )
	    {
	    	return false;
    	}
    	
    	$date_time = time();
	    $subscriber->setAttribute( 'state', 'deleted');
	    $subscriber->setAttribute( 'deleted', $date_time );
		$subscriber->setAttribute( 'modified', $date_time );
		$subscriber->setAttribute( 'modifier_id', $user_id );
	    $subscriber->store();
	
	    return true;
    }

    function unsubscribeByUUID( $uuid, $user_id=null ) {
    	$subscriber = self::fetchByUUID( $uuid );

    	if( !$subscriber || $subscriber->attribute('state') != 'active' )
	    {
	    	return false;
    	}
		
		if( !$user_id )
			$user_id = eZUser::currentUser()->attribute( "contentobject_id" );
    	
    	$date_time = time();
	    $subscriber->setAttribute( 'state', 'unsubscribed');
	    $subscriber->setAttribute( 'unsubscribed', $date_time );
		$subscriber->setAttribute( 'modified', $date_time );
		$subscriber->setAttribute( 'modifier_id', $user_id );
	    $subscriber->store();
	
	    return true;
    }
    
    function undeleteByUUID( $uuid, $user_id ) {
    	$subscriber = self::fetchByUUID( $uuid );

    	if( !$subscriber || $subscriber->attribute('state') != 'deleted' )
	    {
	    	return false;
    	}
    	
    	$date_time = time();
	    $subscriber->setAttribute( 'state', 'active');
	    $subscriber->setAttribute( 'deleted', 0 );
		$subscriber->setAttribute( 'modified', $date_time );
		$subscriber->setAttribute( 'modifier_id', $user_id );
	    $subscriber->store();
	
	    return true;
    }
    
    static public function addSubscription( $email, $name, $list, $force_active = false )
	{
		$date_time    = time();
		$userId 	  = eZUser::currentUser()->attribute( "contentobject_id" ); 
		$subscription = $list->fetchSubscriberByEmail( $email );
		$defaultState = $list->confirmationRequired() && !$force_active ? 'unconfirmed' : 'active';
		
		if( $subscription )
		{
			$currentState = $subscription->attribute("state");
			
			if( $currentState == 'active')
			{
				if( $name )
				{
					$subscription->setAttribute( 'name', $name );
					$subscription->store();
				}
				
				return $subscription;	
			}
			else if( $currentState == 'unsubscribed' )
			{
				$subscription->setAttribute( 'unsubscribed', 0 );
			}
			else if( $currentState == 'bounced' )
			{
				$subscription->setAttribute( 'bounced', 0 );
			}
			else if ( $currentState == 'deleted' )
			{
				return $subscription;
			}			
		}
		else
		{
			$subscription = new jajNewsletterSubscription();
			$subscription->setAttribute( 'subscribed', $date_time );
			$subscription->setAttribute( 'email', $email );
			$subscription->setAttribute( 'subscription_list_id', $list->ID );
			$subscription->setAttribute( 'created', $date_time );
			$subscription->setAttribute( 'creator_id', $userId );
		}
		
		$confirmed_time = ( $defaultState == 'active' ) ? $date_time : 0;	
		
		if( $name ) $subscription->setAttribute( 'name', $name );		
		$subscription->setAttribute( 'state', $defaultState );						
		$subscription->setAttribute( 'confirmed', $confirmed_time );
		$subscription->setAttribute( 'modified', $date_time );
		$subscription->setAttribute( 'modifier_id', $userId );
		
		if ( $subscription->isValid() )
		{
			$subscription->store();			
		}
		
		return $subscription;
	}
	
	static public function createNotificationEvent( $action, $uuid, $list_id )
    {
    	$event = eZNotificationEvent::create( 'jaj_newsletter', 
    		array( 
    			'action' => $action,
            	'uuid' => $uuid,
            	'list_id' => $list_id
        	) 
        );    	
        $event->store();
    }
    
	/* function_attributes */
    function subscriptionList()
    {
        if ( isset( $this->SubscriptionListID ) and $this->SubscriptionListID )
        {
            return jajNewsletterSubscriptionList::fetch( $this->SubscriptionListID );
        }
        return null;
    }
	
    /* Public functions */
    function confirm()
	{
		self::createNotificationEvent( 'confirm', $this->UUID, $this->SubscriptionListID );
		
		if( $this->State == 'active' )
		{
			return true;	
		}
		else if( $this->State != 'unconfirmed' )
		{			
			return false;
		}
		$date_time    = time();
					
		$this->State = 'active';
		$this->Confirmed = $date_time;
		$this->Modified = $date_time;
		$this->ModifierId = eZUser::currentUser()->attribute( "contentobject_id" );
		$this->store();
		
		return true;
	}
	
    function sendConfirmationMail($list)
    {
    	$tpl = eZTemplate::factory();
    	$template = 'design:jaj_newsletter/subscription/mail/confirm.tpl';
 
    	$siteINI = eZINI::instance( 'site.ini' );
    	$i18nINI = eZINI::instance( 'i18n.ini' ); 	

    	$transport = $siteINI->variable( 'MailSettings', 'Transport' );
    	$charset = $i18nINI->variable( 'CharacterSettings', 'Charset' );
		$emailSender = $siteINI->variable( 'MailSettings', 'EmailSender' );
		
    	if( !$emailSender )
	    {
    		$emailSender = $siteINI->variable( 'MailSettings', 'AdminEmail' );
    	}   
    	
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
        		
        $tpl->setVariable( 'subscription', $this );
        $tpl->setVariable( 'list', $list );
        $tpl->setVariable( 'hostname', eZSys::hostname() );
        $templateResult = $tpl->fetch( $template );
		
        $subject = "Please confirm your newsletter subscription";
        if ( $tpl->hasVariable( 'subject' ) )
            $subject = $tpl->variable( 'subject' );
        
		$mail = new ezcMailComposer();
		$mail->charset = $charset;
		$mail->subjectCharset = $charset;
		
		$mail->subject = $subject;
		$mail->plainText = $templateResult;
		
		$mail->from = ezcMailTools::parseEmailAddress( $emailSender, $charset );
		$mail->addTo( new ezcMailAddress( $this->Email, $this->Name, $charset ) );
		
		$mail->build();
		
		$mailTransport->send( $mail );
    }    
    
	function store( $fieldFilters = null )
 	{
 		/* New object ? */
 		if( !isset($this->UUID) )
	 	{
	 		$this->UUID = self::UUID();	
	 	}
	    eZPersistentObject::storeObject( $this, $fieldFilters );
	}
	
    static function create( )
    {
        return new jajNewsletterSubscription( $row );
    }
    
    public function isValid( &$messages = array() )
	{
	    $isValid = true;
	    
	    /* Validate email */
	    if ( !isset( $this->Email ) || $this->Email == '' )
		{
		 	$messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/subscription', 'Email: input required' );
		 	$isValid = false;
		}
		else
		{
			if ( strlen( $this->Email ) > self::MAX_EMAIL_LENGTH )
			{
                $messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/subscription', 'Email: invalid, maximum %max characters allowed',
                    null, array( '%max' => self::MAX_EMAIL_LENGTH ) );
                $isValid = false;				
			}
			else if( !eZMail::validate( $this->Email ) )
			{
		 		$messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/subscription', 'Email: invalid format' );
		 		$isValid = false;					
			}
		}
	    
		/* Validate name */
		if( isset( $this->Name ) && strlen( $this->Name ) > self::MAX_NAME_LENGTH )
		{
            $messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/subscription', 'Name: invalid, maximum %max characters allowed',
            	null, array( '%max' => self::MAX_NAME_LENGTH ) );
            $isValid = false;					
		}
		
		/* Validate state */		
		if( !in_array( $this->State, self::states() ) )
		{
		 	$messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/subscription', 'State: invalid state' );
		 	$isValid = false;	
		}
		
		/* Validate subscrition list id */
		if( !is_numeric( $this->SubscriptionListID ) )
		{
			$messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/subscription', 'Subscription list id: invalid id' );
		 	$isValid = false;		
		}
		
	    return $isValid;	
	}
}
?>
