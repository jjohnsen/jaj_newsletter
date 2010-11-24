<form action={concat("/jaj_newsletter/newsletter_send/", $node.id )|ezurl} method="post">
    <div class="message-warning">
    <h2>
    	<span class="time">[{currentdate()|l10n( shortdatetime )}]</span>
    	{'Confirm delivery of newsletter "%newsletter_name"'|i18n( 'design/admin/jaj_newsletter/newsletter_send', '', hash( '%newsletter_name', $node.name ))|wash()}</h2>
    <p>{'Please consider'|i18n( 'design/admin/jaj_newsletter/newsletter_send' )}:</p>
    <ul>
    	<li>{'This will start the delivery of the newsletter to %recipients recipients.'|i18n( 'design/admin/jaj_newsletter/newsletter_send', '', hash( '%recipients', $unique_recipients) )}</li>
    	<li>{'You should allways preview the newsletter first.'|i18n( 'design/admin/jaj_newsletter/newsletter_send', '', hash( '%recipients', $unique_recipients) )}</li>
    	<li>{'The newsletter will only be delivered once to each recipient.'|i18n( 'design/admin/jaj_newsletter/newsletter_send' )}</li>
    </ul>
    </div>
    
<div class="context-block">
	<div class="block">
		<div class="controlbar">					
			<div class="block">    					
				<div class="button-left">
					<input class="defaultbutton" type="submit" name="SendNewsletterButton" value="{'Confirm'|i18n( 'design/admin/jaj_newsletter/newsletter_send' )}" />
					<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'design/admin/jaj_newsletter/newsletter_send' )}" />
				</div>
				<div class="float-break"></div>
			</div>
		</div>
	</div>
</div>
</form>