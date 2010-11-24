<div class="content-view-full">
	<div class="class-newsletter">
		{if $valid}
		<h1>
			{'Subscription confirmed'|i18n( 'design/admin/jaj_newsletter/subscription/confirm' )}
		</h1>
		<p>
			{'Your subscription has been confirmed.'|i18n( 'design/admin/jaj_newsletter/subscription/confirm' )}
		</p>
		{else}
		<h1>
			{'Confirmation failed'|i18n( 'design/admin/jaj_newsletter/subscription/confirm' )}
		</h1>
		<div class="message-warning">
		<p>
			{'Sorry, you confirmation link has expired or is invalid.'|i18n( 'design/admin/jaj_newsletter/subscription/confirm' )}		
		</p>
		</div>
		{if $list}
		<p>	
			{'You can still subscribe to %list <a href="%link">here</a>.'|i18n( 
				'design/admin/jaj_newsletter/subscription/confirm',,
				hash(
					'%list', $list.name, 
					'%link', concat("/jaj_newsletter/subscribe/", $list.id )|ezurl('no')
				)
			)}
		</p>
		{/if}
		
		{/if}
	</div>
</div>