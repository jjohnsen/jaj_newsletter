{* See parts/ini_menu.tpl and menu.ini for more info, or parts/setup/menu.tpl for full example *}
{include uri='design:parts/ini_menu.tpl' ini_section='Leftmenu_jaj_newsletter' i18n_hash=hash(
    'jaj_newsletter',   'Newsletter'|i18n( 'jaj_newsletter/navigation' ),
    'overview',         'Overview'|i18n( 'jaj_newsletter/navigation' ),
    'newsletters',      'Newsletters'|i18n( 'jaj_newsletter/navigation' ),
    'subscription_lists','Subscription Lists'|i18n( 'jaj_newsletter/navigation' ),
    'settings',      	'Settings'|i18n( 'jaj_newsletter/navigation' )
)}

{*
  'subscribers',		'Subscribers'|i18n( 'jaj_newsletter/navigation' ),
    'reports',      	'Reports'|i18n( 'jaj_newsletter/navigation' ),
*}