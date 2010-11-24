<div class="content-view-full">
	<div class="class-newsletter">
		<h1>
			{'Thank you for subscribing to our newsletter!'|i18n( 'design/admin/jaj_newsletter/subscription')}			
		</h1>
		
		<p>
			{'You are now registered to receive our newsletter: %newsletter.'|i18n('design/admin/jaj_newsletter/subscription',, hash('%newsletter', $list.name ))}			
		</p>
		
		{if $subscription.state|eq('unconfirmed')}
		<h2>{'Important'|i18n( 'design/admin/jaj_newsletter/subscription')}</h2>
        <p>
			{'An email was sent to your address: %email.'|i18n('design/admin/jaj_newsletter/subscription',, hash( '%email' , $subscription.email ) ) }
		</p>
		<p>
			{'You have to click on the confirmation link in this email before you subscription is activated.'|i18n('design/admin/jaj_newsletter/subscription')}			
		</p>
		{/if}

		<p>
			<a href={'/'|ezurl()}>{'Back to our site'|i18n( 'design/admin/jaj_newsletter/subscription')}</a>			
		</p>
	</div>
</div>