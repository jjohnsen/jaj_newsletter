<div class="content-view-full">
	<div class="class-newsletter">
		<h1>
			{'Sorry, you can not subscribe to this newsletter'|i18n( 'design/admin/jaj_newsletter/subscription')}			
		</h1>		
		
		<p>
			{'If you think this is an error, please contact the site admin: %admin.'|i18n( 'design/admin/jaj_newsletter/subscription',, hash('%admin', ezini('MailSettings','AdminEmail')))}
			
		</p>
		<p>
			<a href={'/'|ezurl()}>{'Back to our site'|i18n( 'design/admin/jaj_newsletter/subscription')}</a>			
		</p>		
	</div>
</div>