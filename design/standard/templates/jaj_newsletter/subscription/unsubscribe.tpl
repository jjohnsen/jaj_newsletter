<div class="content-view-full">
	<div class="class-newsletter">
		<h1>
			{'Unsubscribe from newsletter'|i18n( 'design/admin/jaj_newsletter/unsubscribe' )}
		</h1>
		
		{if $subscriptions|count()}
		<div class="block">
			<p>
				{'The e-mail address: %email is currently subscribed to the following newsletters:'|i18n( 'design/admin/jaj_newsletter/unsubscribe',, hash( '%email', $subscription.email) )}
			</p>
		</div>
		
		<table>
		<tr>
			<th>{'Newsletter'|i18n( 'design/admin/jaj_newsletter/unsubscribe' )}</th>
			<th></th>
		</tr>
		{foreach $subscriptions as $sub}
		<tr>
			<td>
				{$sub.subscription_list.name}
			</td>
			<td>
				<form method="post" action={concat('jaj_newsletter/unsubscribe/', $sub.uuid)|ezurl()}>
					<input type="submit" name="ConfirmUnsubscribeButton" value="{'Unsubscribe'|i18n( 'design/admin/jaj_newsletter/unsubscribe' )}" />
				</form>
			</td>
		</tr>
		{/foreach}
		</table>
		{else}
		<div class="block">
			<p>
				{'The e-mail address: %email is not subscribed to any newsletters.'|i18n( 'design/admin/jaj_newsletter/unsubscribe',, hash( '%email', $subscription.email) )}
			</p>
		</div>		
		{/if}
	</div>
</div>