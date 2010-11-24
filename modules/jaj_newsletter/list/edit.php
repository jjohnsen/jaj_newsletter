<?php
$ListID = $Params['ListID'];
$Module = $Params[ 'Module' ];

$user = eZUser::currentUser();
$user_id = $user->attribute( "contentobject_id" );

$list = $ListID === null ? jajNewsletterSubscriptionList::create( $user_id ) : jajNewsletterSubscriptionList::fetch( $ListID );

if ( !is_object( $list ) )
{
    return $Module->handleError( eZError::KERNEL_NOT_FOUND, 'kernel' );
}

$tpl = eZTemplate::factory();

if ( $Module->isCurrentAction( 'Cancel' ) )
{
	return $Module->redirectTo( $Module->functionURI( "lists" ) );
}
else if ( $Module->isCurrentAction( 'Store' ) )
{
	$list->fetchHTTPPersistentVariables();

    $messages = array();
    
	$list->setAttribute( "modified", time() );
	$list->setAttribute( "modifier_id", $user_id );
    
    $isValid = $list->isValid( $messages );

    if ( $isValid )
    {
        $list->store();
        
        if ( $ListID === null )
        {
            return $Module->redirectTo( $Module->functionURI( "list" ) . '/' . $list->attribute( 'id' ) );
        }
        else
        {
            return $Module->redirectTo( $Module->functionURI( "lists" ) );
        }
    }
        
    $tpl->setVariable( 'is_valid', $isValid );
    $tpl->setVariable( 'validation_messages', $messages );    
}

$tpl->setVariable( 'list', $list );

$path = array(
	array( 'url' => 'jaj_newsletter/index', 'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' ) ),
	array( 'url' => 'jaj_newsletter/lists', 'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Subscription Lists' ) )
);

if ( $ListID === null )
{
	array_push( $path, array( 'url' => false, 'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'New list' ) ) );
}
else
{
	array_push( $path, array( 'url' => false, 'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Edit list' ) ) );
}

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/lists/edit.tpl' ),
    'path'    => $path
);

?>