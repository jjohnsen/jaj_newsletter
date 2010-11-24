<?php

class jajNewsletterDelivery extends eZPersistentObject
{	
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
        							'contentobject_id' =>  array( 
        								'name' => 'ContentObjectID',
                                        'datatype' => 'integer',
                                        'default' => 0,
                                        'required' => true,
                                        'foreign_class' => 'eZContentObject',
                                        'foreign_attribute' => 'id',
                                        'multiplicity' => '1..*'
                               		),
                               		"uuid" => array( 
        								"name" => "UUID",
                                        "datatype" => "string",
                                        "required" => true,
                                        'foreign_class' => 'jajNewsletterSubscription',
                                        'foreign_attribute' => 'uuid',
                                        'multiplicity' => '1..*'
                                    ),
                                    "email" => array( 
                                    	"name" => "Email",
                                        "datatype" => "string",
                                        "required" => true,
                                        "max_length" => jajNewsletterSubscription::MAX_EMAIL_LENGTH
                                    ),
                                    "state" => array( 
                                    	"name" => "State",
                                        "datatype" => "string",
                                        "required" => true,
                                        "max_length" => 12
                                    ),
                					"created" => array( 
											'name' => "Created",
                                            'datatype' => 'integer',
                                            'default' => 0,
                                            'required' => true
                                    ),
                					"sent" => array( 
											'name' => "Sent",
                                            'datatype' => 'integer',
                                            'required' => false 
                                    ),
                					"opened" => array( 
											'name' => "Opened",
                                            'datatype' => 'integer',
                                            'required' => false 
                                    ),
                					"viewed" => array( 
											'name' => "Viewed",
                                            'datatype' => 'integer',
                                            'required' => false 
                                    ),                                                                                                                                                                                                                                                                                 
                                ),
                                "increment_key" => "id",                                
                      			"keys" => array( "id" ),
                      			"class_name" => "jajNewsletterDelivery",
                       			"name" => "jaj_newsletter_delivery" );
        return $definition;
    }
	
	static function states()
	{
		return array("pending", "sent", "failed");
	}
	
    static function fetchDeliveriesByContentobjectID( $contentobject_id, $limit=25, $offset=0, $as_object=true )
    {
    	return eZPersistentObject::fetchObjectList( jajNewsletterDelivery::definition(),			
    								null,
    								array(
	    								'contentobject_id' => $contentobject_id
    								),
    								array( 'email' => 'asc' ),
    								array( 'offset' => $offset, 'length' => $limit ),
	    							$as_object,
	    							false
	    );
    }

    static function fetchDeliveriesByContentobjectIDAndState( $object_id, $status=array(), $limit=25, $offset=0, $as_object=true )
    {
    	$conds = array( 'contentobject_id' => $object_id );
    	
    	if( is_string($status) )
    		$status = array( $status );
    	
    	if( is_array($status) )
    		$status = array_intersect( jajNewsletterDelivery::states(), $status);
    	
    	if( count( $status ) )
    		$conds['state'] = array( $status );
    		
    	return eZPersistentObject::fetchObjectList( jajNewsletterDelivery::definition(),			
    								null,
    								$conds,
    								array( 'email' => 'asc' ),
    								array( 'offset' => $offset, 'length' => $limit ),
	    							$as_object,
	    							false
	    );
    }    
    
    static function fetchDeliveriesByContentobjectIdCount( $object_id, $status=array() )
    {
    	$conds = array( 'contentobject_id' => $object_id );
    	
    	if( is_string($status) )
    		$status = array( $status );
    	
    	if( is_array($status) )
    		$status = array_intersect( jajNewsletterDelivery::states(), $status);
    	
    	if( count( $status ) )
    		$conds['state'] = array( $status );
    	
    	$rows = eZPersistentObject::count( jajNewsletterDelivery::definition(), $conds );
    	return $rows;
    }
	
	static function fetch( $id )
	{
		return eZPersistentObject::fetchObject( jajNewsletterDelivery::definition(), null, array( 'id' => $id ) );
	}
	
	static function fetchByObjectIdAndUUID( $object_id, $uuid )
	{
		return eZPersistentObject::fetchObject( jajNewsletterDelivery::definition(), null, array( 'contentobject_id' => $object_id, 'uuid' => $uuid ) );
	}
	
    static function fetchDelivery( $id )
    {	
    	$result = eZPersistentObject::fetchObject( jajNewsletterDelivery::definition(), null, array( 'id' => $id ) );
       	return array( 'result' => $result );
    }
    
    static function fetchDeliveryByObjectIdAndUUID( $object_id, $uuid )
    {	
    	$result = eZPersistentObject::fetchObject( jajNewsletterDelivery::definition(), null, array( 'contentobject_id' => $object_id, 'uuid' => $uuid ) );
       	return array( 'result' => $result );
    }    
       
    static function fetchNewsletterDeliveryCount( $object_id, $status=array() )
    {
       	return array( 'result' => jajNewsletterDelivery::fetchDeliveriesByContentobjectIdCount( $object_id, $status ) );
    }
    
    static function generateDeliveryForNewsletter( $node )
    {
    	// TODO: Should use a different method / datatype
    	// Better with string
    	
    	$data_map = $node->DataMap();
		$status = $data_map['status'];
		$status->fromString("in progress");
		$status->store();

    	$subscribers = jajNewsletterSubscription::fetchUniqueForNewsletterId( $node->ID, false );
		$result = 0;
		
		foreach ( $subscribers as $subscription )
		{
			$row = array(
        		"contentobject_id" => $node->ID,
				"uuid" => $subscription['uuid'],
				"email" => $subscription['email'],
				"state" => "pending",
				"created" => time()
			);
			$delivery = new jajNewsletterDelivery( $row );
			$delivery->store();
			$result += 1;
			
		}
		return $result;
    }
    
    /* Function Attributes */
    function markAsOpened()
    {
    	if( $this->attribute( 'opened') )
    		return;

    	$this->setAttribute( 'opened', time() );
    	$this->store();
    }
    
    function markAsViewed()
    {
    	if( $this->attribute( 'viewed') )
    		return;

    	$this->setAttribute( 'viewed', time() );
    	$this->store();    
    }
}
?>
