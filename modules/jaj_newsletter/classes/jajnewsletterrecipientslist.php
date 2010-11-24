<?php

class jajNewsletterRecipientsList extends eZPersistentObject
{	
    function __construct( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    public static function definition()
    {
        static $definition = array( 
        						"fields" => array(         							
        							'contentobject_id' =>  array( 
        								'name' => 'ContentObjectID',
                                        'datatype' => 'integer',
                                        'default' => 0,
                                        'required' => true,
                                        'foreign_class' => 'eZContentObject',
                                        'foreign_attribute' => 'id',
                                        'multiplicity' => '1..*'
                               		),
                                    "subscription_list_id" => array( 
                                    	"name" => "SubscriptionListID",
                                        'datatype' => 'integer',
                                        'default' => 0,
                                        'required' => true,
                                        'foreign_class' => 'jajNewsletterSubscriptionList',
                                        'foreign_attribute' => 'id',
                                        'multiplicity' => '1..*'
                                    )                                                                                        
                                ),                                
                      			"keys" => array( "contentobject_id", "subscription_list_id" ),
                      			"class_name" => "jajNewsletterRecipientsList",
                      			"function_attributes" => array(
                      				'subscription_list' => 'subscriptionList'
                      			),
                      			"name" => "jaj_newsletter_recipients_list" );
        return $definition;
    }

    static function create( $contentobject_id, $subscription_list_id )
    {
        $row = array(
        		"contentobject_id" => $contentobject_id,
				"subscription_list_id" => $subscription_list_id
		);
        return new jajNewsletterRecipientsList( $row );
    }
    
    static function fetch( $contentobject_id, $subscription_list_id, $asObject = true )
    {		
		return eZPersistentObject::fetchObject( jajNewsletterRecipientsList::definition(),
                                                null,
                                                array( 
                                                	'contentobject_id' => $contentobject_id,
                                                	'subscription_list_id' => $subscription_list_id
                                                ),
                                                $asObject );		
    }

    static function fetchByContentObjectID( $contentobject_id , $asObject = true )
    {
    	return eZPersistentObject::fetchObjectList( jajNewsletterRecipientsList::definition(),			
    								null,
    								array(
	    								'contentobject_id' => $contentobject_id
    								),
    								null,
    								null,
	    							$asObject );
    }    
    
    static function removeByContentObjectID( $contentobject_id )
    {
    	return eZPersistentObject::fetchObjectList( jajNewsletterRecipientsList::definition(),
    								array(
	    								'contentobject_id' => $contentobject_id
    								)
    	);
    }
    
    /* Function Attributes */
    function subscriptionList()
    {
        if ( isset( $this->SubscriptionListID ) and $this->SubscriptionListID )
        {
            return jajNewsletterSubscriptionList::fetch( $this->SubscriptionListID );
        }
        return null;
    }
    
    /*
    static function create( )
    {
        return new jajNewsletterSubscription( $row );
    }
    */
}
?>
