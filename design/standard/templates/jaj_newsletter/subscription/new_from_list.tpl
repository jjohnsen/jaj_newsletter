<div class="content-view-full">
	<div class="class-newsletter">
		<h1>
			{'Subscribe to newsletter'|i18n( 'design/admin/jaj_newsletter/subscription',, hash('%name', $list.name|wash()) )}
		</h1>
		
		{if is_set($is_error)}
		<div class="message-error">
			<h2>{'An error occurred, please try again later.'|i18n( 'design/admin/jaj_newsletter/subscription' )}</h2>
			<ul>
		    {foreach $error_messages as $message}
		    <li>{$message|wash}</li>
		    {/foreach}
		    </ul>
		</div>
		{/if}
		
		{if and( is_set($is_valid), $is_valid|not() )}
		    <div class="message-warning">
		    <h2>		    	
		    	{'Subscription could not be stored.'|i18n( 'design/admin/jaj_newsletter/subscription' )}
	    	</h2>
		    <p>{'Required data is either missing or is invalid'|i18n( 'design/admin/jaj_newsletter/subscription' )}:</p>
		    <ul>
		    {foreach $validation_messages as $message}
		    <li>{$message|wash}</li>
		    {/foreach}
		    </ul>
		    </div>
		{/if}

		<form action={concat("/jaj_newsletter/subscribe/")|ezurl} method="post">

		<div class="block">
			<label for="SubscritionEmail">{'Newsletter'|i18n( 'design/admin/jaj_newsletter/subscription' )}:</label>
			<input type="radio" name="SubscriptionListID" value="2" {if $list.id|eq(2)}checked="checked"{/if}>Privat
			<input type="radio" name="SubscriptionListID" value="3" {if $list.id|eq(3)}checked="checked"{/if}>Proff
		</div>
	
		<div class="block">
			<label for="SubscriptionName">{'Name'|i18n( 'design/admin/jaj_newsletter/subscription' )}:</label>
			<input type="text" name="SubscriptionName" size="20" maxlength="150" value="{$subscription.name|wash}" />
		</div>

		<div class="block">
			<label for="SubscritionEmail">{'Email'|i18n( 'design/admin/jaj_newsletter/subscription' )}:</label>
			<input type="text" name="SubscriptionEmail" size="20" maxlength="150" value="{$subscription.email|wash}" />
		</div>
		
		<div class="buttonblock">
			<input type="submit" value="{'Subscribe'|i18n( 'design/admin/jaj_newsletter/subscription' )}" name="SubscribeButton" class="button" />
		</div>
		
		</form>
	</div>
</div>