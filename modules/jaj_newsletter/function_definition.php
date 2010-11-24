<?php

$FunctionList = array();

$FunctionList['newsletter_recipients_count'] = 	array( 	'name' => 'newsletter_recipients_count',
                                 						'call_method' => array( 
                                 						'include_file' => 'extension/jaj_newsletter/modules/jaj_newsletter/classes/jajnewslettersubscription.php',
                                                	    'class' => 'jajNewsletterSubscription',
                                                    	'method' => 'fetchNewsletterRecipientsCount'
                                 					),
                                 					'parameter_type' => 'standard',
                                 				
                                 					'parameters' => array ( 
                                 						array (	'name' => 'object_id',
                                                        	    'type' => 'integer',
                                                            	'required' => true 
                                                		),
                                                		array ( 'name' => 'status',
                                                				'type' => 'string',
                                                				'required' => false
                                                		)
                                                	)
                                      			);

$FunctionList['newsletter_delivery_count'] = 	array( 	'name' => 'newsletter_delivery_count',
                                 						'call_method' => array( 
                                 						'include_file' => 'extension/jaj_newsletter/modules/jaj_newsletter/classes/jajnewsletterdelivery.php',
                                                	    'class' => 'jajNewsletterDelivery',
                                                    	'method' => 'fetchNewsletterDeliveryCount'
                                 					),
                                 					'parameter_type' => 'standard',
                                 				
                                 					'parameters' => array ( 
                                 						array (	'name' => 'object_id',
                                                        	    'type' => 'integer',
                                                            	'required' => true 
                                                		),
                                                		array ( 'name' => 'status',
                                                				'type' => 'string',
                                                				'required' => false
                                                		)
                                                	)
                                      			);
                                      			
$FunctionList['newsletter_delivery'] = 			array( 	'name' => 'newsletter_delivery',
                                 						'call_method' => array( 
                                 						'include_file' => 'extension/jaj_newsletter/modules/jaj_newsletter/classes/jajnewsletterdelivery.php',
                                                	    'class' => 'jajNewsletterDelivery',
                                                    	'method' => 'fetchDelivery'
                                 					),
                                 					'parameter_type' => 'standard',
                                 				
                                 					'parameters' => array ( 
                                 						array (	'name' => 'id',
                                                        	    'type' => 'integer',
                                                            	'required' => true 
                                                		)
                                                	)
                                      			);                                             			

$FunctionList['newsletter_delivery_by_object_id_and_uuid'] = array( 	'name' => 'newsletter_delivery_by_object_id_and_uuid',
                                 						'call_method' => array( 
                                 						'include_file' => 'extension/jaj_newsletter/modules/jaj_newsletter/classes/jajnewsletterdelivery.php',
                                                	    'class' => 'jajNewsletterDelivery',
                                                    	'method' => 'fetchDeliveryByObjectIdAndUUID'
                                 					),
                                 					'parameter_type' => 'standard',
                                 				
                                 					'parameters' => array ( 
                                 						array (	'name' => 'object_id',
                                                        	    'type' => 'integer',
                                                            	'required' => true 
                                                		),
                                                		array (	'name' => 'uuid',
                                                        	    'type' => 'string',
                                                            	'required' => true 
                                                		),
                                                	)
                                      			);  

?>