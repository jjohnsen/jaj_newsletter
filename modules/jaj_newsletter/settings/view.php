<?php

$Module = $Params[ 'Module' ];

$tpl = eZTemplate::factory();

$Result = array(
    'content' => $tpl->fetch( 'design:jaj_newsletter/settings/view.tpl' ),
    'path'    => array(
        array( 
			'url' => 'jaj_newsletter/index', 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )														
		),
		array(
			'url' => false, 
			'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Settings' ),		
		)
    )
);

?>