<?php

class jajNewsletterSubscriptionList extends eZPersistentObject
{
	const MAX_NAME_LENGTH = 45;
	
    function __construct( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    public static function definition()
    {
        static $definition = array( 
        						"fields" => array(         							
        							"id" => array( 
        								"name" => "ID",
                                        "datatype" => "integer",
                                        "required" => true
                                    ),
                                    "name" => array( 
                                    	"name" => "Name",
                                        "datatype" => "string",
                                        "required" => true,
                                        "max_length" => self::MAX_NAME_LENGTH
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
                                    )                                 
                                ),                                
                      			"keys" => array( "id" ),
                      			"function_attributes" => array(
                      				'creator' => 'creator',
                      				'modifier' => 'modifier',
                      				'subscribers_count' => 'fetchSubscribersCount',
                      				'active_subscribers_count' => 'fetchActiveSubscribersCount',
                      				'subscribers' => 'fetchSubscribers',
                      				'confirmation_required' => 'confirmationRequired',
                      				'subscribe_url' => 'subscribeURL',
                      				'unsubscribe_url' => 'unsubscribeURL'                				
                      			),
                      			"increment_key" => "id",
                      			"class_name" => "jajNewsletterSubscriptionList",
                      			"sort" => array( "identifier" => "asc" ),
                      			"name" => "jaj_newsletter_subscription_list" );
        return $definition;
    }
    
    static function create( $user_id )
    {
        $date_time = time();
        $row = array(
            "id" => null,
            "name" => "",
            "creator_id" => $user_id,
            "modifier_id" => $user_id,
            "created" => $date_time,
            "modified" => $date_time );
        return new jajNewsletterSubscriptionList( $row );
    }

    static function fetch( $id, $asObject = true )
    {
        $listObject = eZPersistentObject::fetchObject( jajNewsletterSubscriptionList::definition(),
                                                null,
                                                array( 'id' => $id ),
                                                $asObject );
        return $listObject;
    }

    static function fetchByName( $name , $asObject = true )
    {
        $listObject = eZPersistentObject::fetchObject( jajNewsletterSubscriptionList::definition(),
                                                null,
                                                array( 'name' => $name ),
                                                $asObject );
        return $listObject;
    }    
    
    public static function fetchByOffset( $limit=25, $offset=0, $asObject=true )
    {
    	return eZPersistentObject::fetchObjectList( jajNewsletterSubscriptionList::definition(),			
    								null,
    								null,
    								array( 'name' => 'asc' ),
    								array( 'offset' => $offset, 'length' => $limit ),
	    							$asObject,
	    							false
	    );
    }
    
    /* Function attributes */
    
    function confirmationRequired() {
    	return false;
    }
    
    function subscribeURL() {
    	$ini = eZINI::instance( 'site.ini' );
    	$site_url = $ini->variable( 'SiteSettings', 'SiteURL' );
    	 
    	return "http://" . $site_url . "/jaj_newsletter/subscribe/" . $this->ID;
    }
    
    function unsubscribeURL() {
    	$ini = eZINI::instance( 'site.ini' );
    	$site_url = $ini->variable( 'SiteSettings', 'SiteURL' );
    	 
    	return "http://" . $site_url . "/jaj_newsletter/unsubscribe/" . $this->ID;    	
    }
    
    /* Public functions */
    
    public function fetchHTTPPersistentVariables()
    {
        $http = eZHTTPTool::instance();
        eZHTTPPersistence::fetch( 'ContentObjectNewsletterSubscriptionList' , jajNewsletterSubscriptionList::definition(), $this, $http, false );
    }
    
	public function isValid( &$messages = array() )
	{
		$isValid = true;
		
		if ( !isset( $this->Name ) || $this->Name == '' )
		{
		 	$messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/list_edit', 'Name: input required' );
		 	$isValid = false;
		}
		else
		{
			if ( strlen( $this->Name ) > self::MAX_NAME_LENGTH ) {
                $messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/list_edit', 'Name: invalid, maximum %max characters allowed.',
                                      null, array( '%max' => self::MAX_NAME_LENGTH ) );
                $isValid = false;				
			}
			else
			{
				$existingList = self::fetchByName( $this->Name );
                if ( $existingList && ( !isset( $this->ID ) || $existingList->attribute( 'id' ) !== $this->ID ) )
                {
                    $messages[] = ezpI18n::tr( 'design/admin/jaj_newsletter/list_edit', 'Name: a subscription list with this name already exists, please use another name' );
                    $isValid = false;
                }
			}
		}
		return $isValid;
	}
	
	public function fetchRecipientsLists($asObject=true)
	{
		return eZPersistentObject::fetchObjectList( jajNewsletterRecipientsList::definition(), null, array('subscription_list_id' => $this->ID), array(), array(), $asObject );
	}
	
	public function fetchSubscribers($asObject=true)
	{
		return eZPersistentObject::fetchObjectList( jajNewsletterSubscription::definition(), null, array('subscription_list_id' => $this->ID), array(), array(), $asObject );
	}
    
    public function fetchSubscribersByState( $state='active', $limit=25, $offset=0, $asObject=true )
    {
    	return eZPersistentObject::fetchObjectList( jajNewsletterSubscription::definition(),			
    								null,
    								array(
	    								'subscription_list_id' => $this->ID,
		    							'state' => $state	
    								),
    								array( 'created' => 'asc' ),
    								array( 'offset' => $offset, 'length' => $limit ),
	    							$asObject );
    }
    	
    public function fetchSubscribersCount( $state = null )
	{
		$conditions = array( 'subscription_list_id' => $this->ID );

		if( $state )
    		$conditions['state'] = $state;

    	return eZPersistentObject::count( jajNewsletterSubscription::definition(), $conditions );
	}
	
	public function fetchActiveSubscribersCount( )
	{
		return $this->fetchSubscribersCount( 'active' );
	}
	
	public function fetchSubscriberByEmail( $email, $asObject=true )
	{
        return eZPersistentObject::fetchObject( jajNewsletterSubscription::definition(),
                                                null,
                                                array( 
                                                	'email' => $email,
                                                	'subscription_list_id' => $this->ID
                                                ),
                                                $asObject );
	}
	
	public function createSubscribersFromList(  &$subscribers, &$messages = array() )
	{		
		$list = explode( "\n", $subscribers);
		$returnList = array();
		$user = eZUser::currentUser();
		$user_id = $user->attribute( "contentobject_id" );
		$date_time = time();

		foreach ($list as $line) 
		{
			list($email, $name) = explode( ',', $line );
			
			if( strpos( $name, "@") !== false )
			{
				list($email, $name) = array( $name, $email );
			}						
			list($email, $name) = array( trim($email), trim($name) );
			
			$subscriber = $this->fetchSubscriberByEmail( $email );
			
			$action = "ignore";			
			if( $subscriber == NULL )
			{
				$subscriber = jajNewsletterSubscription::create();
				$subscriber->setAttribute( 'email', $email );
				$subscriber->setAttribute( 'name', $name );
				$subscriber->setAttribute( 'subscription_list_id', $this->ID );
				$subscriber->setAttribute( 'state', 'active' );
				$subscriber->setAttribute( 'subscribed', $date_time  );
				$subscriber->setAttribute( 'created', $date_time );
				$subscriber->setAttribute( 'creator_id', $user_id );
				
				$action = $subscriber->isValid() ? "add" : "invalid";
			}			
			else if( $subscriber->attribute( 'state') == 'active' && $name )
			{
				$subscriber->setAttribute( 'name', $name );
				$action = $subscriber->isValid() ? "update" : "invalid";
			}
						
			if( $action == 'add' || $action == 'update' )
			{
				$subscriber->setAttribute( 'modified', $date_time );
				$subscriber->setAttribute( 'modifier_id', $user_id );
				$subscriber->store();					
			}
			else if( $action == 'invalid' )
			{
				array_push( $returnList, $line);
			}
			$messages[$action] = isset($messages[$action]) ? $messages[$action]+1 : 1;
		}
		$subscribers = implode( "\n", $returnList );
	}
	
	// TODO: Rewrite
    function remove( $conditions = null, $extraConditions = null )
    {
    	foreach( $this->fetchRecipientsLists() as $list )
    	{
    		$list->remove();
    	}
    	
    	foreach( $this->fetchSubscribers() as $subscriber )
    	{
    		$subscriber->remove();
    	}
    	
    	eZPersistentObject::remove();
    }
    
}
?>
