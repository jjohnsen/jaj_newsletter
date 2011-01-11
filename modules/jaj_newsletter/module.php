<?php
/**
 * File module.php
 *
 * @copyright Copyright (C) 2007-2010 CJW Network - Coolscreen.de, JAC Systeme GmbH, Webmanufaktur. All rights reserved.
 * @license http://ez.no/licenses/gnu_gpl GNU GPL v2
 * @version 1.0.0beta | $Id: module.php 10958 2010-03-30 13:39:59Z felix $
 * @package cjw_newsletter
 * @subpackage modules
 * @filesource
 */

$Module = array( "name" => "JAJ Newsletter" );

$ViewList = array();

$ViewList['index'] = array(
    'script' => 'index.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'params' => array( ) );

$ViewList['lists'] = array(
    'script' => 'list/index.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'NewListButton' => 'NewList' ),
    'params' => array( ) );

$ViewList['list'] = array(
    'script' => 'list/view.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'unordered_params' => array( 'offset' => 'Offset' ),
    'single_post_actions' => array( 
    	'AddSubscribersButton' => 'AddSubscribers',
    	'DeleteSubscribersButton' => 'DeleteSubscribers',
    	'UnsubscribeSubscribersButton' => 'UnsubscribeSubscribers',
    	'UndeleteSubscribersButton' => 'UndeleteSubscribers'
    ),
    'post_action_parameters' => array( 
    	'DeleteSubscribers' => array( 'SubscriberUUIDArray' => 'SubscriberUUIDArray' ),
    	'UnsubscribeSubscribers' => array( 'SubscriberUUIDArray' => 'SubscriberUUIDArray' ),
    	'UndeleteSubscribers' => array( 'SubscriberUUIDArray' => 'SubscriberUUIDArray' ),    	
    ),    
    'params' => array( 'ListID', 'ViewState' ) );

$ViewList["list_edit"] = array(
    "script" => "list/edit.php",
    'ui_context' => 'edit',
	'functions' => array( 'admin' ),
    "default_navigation_part" => 'jaj_newsletternavigationpart',
    "params" => array( "ListID" ),
    'single_post_actions' => array( 'StoreButton' => 'Store',
                                    'CancelButton' => 'Cancel' )
);

$ViewList['list_add'] = array(
    'script' => 'list/add.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'StoreButton' => 'Store',
                                    'CancelButton' => 'Cancel' ),    
    'post_action_parameters' => array( 'Store' => array( 'SubscribersList' => 'SubscribersList' ) ),
    'params' => array( 'ListID' ) 
);

$ViewList['list_remove'] = array(
    'script' => 'list/remove.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'ConfirmButton' => 'Confirm',
                                    'CancelButton' => 'Cancel' ),    
    'post_action_parameters' => array( 'Confirm' => array( 'SubscribersList' => 'SubscribersList' ) ),
    'params' => array( 'ListID' ) 
);

/* Newsletter */

$ViewList['newsletters'] = array(
    'script' => 'newsletter/index.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'unordered_params' => array( 'offset' => 'Offset' ),
    'params' => array( ) );

$ViewList['newsletter'] = array(
    'script' => 'newsletter/view.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'unordered_params' => array( 'tab' => 'Tab', 'offset' => 'Offset' ),
    'params' => array( 'NewsletterNodeID' ) );
    
$ViewList['newsletter_add_recipients'] = array(
    'script' => 'newsletter/add_recipients.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'StoreButton' => 'StoreRecipients',
                                    'CancelButton' => 'Cancel',
                                    'RemoveRecipientsList' => 'RemoveRecipientsList' ),
 	'post_action_parameters' => array( 
    	'StoreRecipients' => array( 'SubscriptionListIdArray' => 'SubscriptionListIdArray' ),
    	'RemoveRecipientsList' => array( 'SubscriptionListID' => 'SubscriptionListID' )
    ),
    'params' => array( 'NewsletterID' ) );

$ViewList['preview'] = array(
    'script' => 'newsletter/preview.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'SendPreview' => 'SendPreview' ),
    'post_action_parameters' => array( 
    	'SendPreview' => array( 'EmailAddress' => 'EmailAddress' )
    ),
    'unordered_params' => array( 'mode' => 'Mode' ),
    'params' => array( 'NewsletterNodeID' ) );

$ViewList['newsletter_send'] = array(
    'script' => 'newsletter/send.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'SendNewsletterButton' => 'SendNewsletter',
                                    'CancelButton' => 'Cancel' ),
    'params' => array( 'NewsletterID' ) );

$ViewList['newsletter_graph'] = array(
    'script' => 'newsletter/graph.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'params' => array( 'ObjectID', 'GraphType' ) );

$ViewList['track'] = array(
    'script' => 'newsletter/track.php',
    'functions' => array( 'manage_subscription' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'params' => array( 'object_id', 'uuid', 'operation' ) );

/* Settings */

$ViewList['settings'] = array(
    'script' => 'settings/view.php',
    'functions' => array( 'admin' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'params' => array( ) );

/* subscription */

$ViewList['subscribe'] = array(
    'script' => 'subscription/new.php',
    'functions' => array( 'manage_subscription' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'SubscribeButton' => 'Subscribe' ),
    'post_action_parameters' => array( 
    	'Subscribe' => array( 
    		'SubscriptionEmail' => 'SubscriptionEmail',
    		'SubscriptionName' => 'SubscriptionName',
    		'SubscriptionListID' => 'SubscriptionListID',    		
    	) 
    ),
    'params' => array( 'ListID' ) );    

$ViewList['confirm'] = array(
    'script' => 'subscription/confirm.php',
    'functions' => array( 'manage_subscription' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',   
    'params' => array( 'UUID' ) );

$ViewList['unsubscribe'] = array(
    'script' => 'subscription/unsubscribe.php',
    'functions' => array( 'manage_subscription' ),
    'default_navigation_part' => 'jaj_newsletternavigationpart',
    'single_post_actions' => array( 'ConfirmUnsubscribeButton' => 'ConfirmUnsubscribe' ),   
    'params' => array( 'UUID' ) );        


$FunctionList['admin'] = array();
$FunctionList['manage_subscription'] = array();

?>