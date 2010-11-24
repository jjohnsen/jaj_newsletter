{*?template charset=utf-8?*}{set-block variable=$subject scope=root}{'Please confirm your subscription to %list'|i18n( 'jaj_newsletter/subscription/mail/confirm',, hash('%list', $list.name) )}{/set-block}

{'Hi %name

Thanks for subscribing to %list

To complete your subscription, you need to confirm you got this email.

Confirm you subscription by clicking on link bellow:

%confirm_link


If subscribed in error or want to unsubscribe, click the link bellow:

%unsubscribe_link'|i18n( 'jaj_newsletter/subscription/mail/confirm',, 
	hash(	'%name', $subscription.name, 
			'%list', $list.name, 
			'%confirm_link', concat("/jaj_newsletter/confirm/", $subscription.uuid )|ezurl('no', 'full'),
			'%unsubscribe_link', concat("/jaj_newsletter/unsubscribe/", $subscription.uuid )|ezurl('no', 'full'),
		) 
	)}