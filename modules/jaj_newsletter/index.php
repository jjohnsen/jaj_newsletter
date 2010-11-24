<?php

include_once( 'kernel/common/template.php' );

$module = $Params[ 'Module' ];
$http = eZHTTPTool::instance();

$viewParameters = array();
$tpl = templateInit();
$tpl->setVariable( 'view_parameters', $viewParameters );

$tpl->setVariable( 'current_siteaccess', $viewParameters );
$Result = array();
$Result['content'] = $tpl->fetch( "design:jaj_newsletter/index.tpl" );

$Result['path'] = array( 	array( 
								'url' => 'jaj_newsletter/index', 
								'text' => ezpI18n::tr( 'jaj_newsletter/navigation', 'Newsletter' )
							),
                        );

?>