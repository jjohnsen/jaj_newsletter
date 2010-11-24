<form name="subscription_lists" action={concat("/jaj_newsletter/newsletter_add_recipients/", $node.id )|ezurl} method="post">
	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{'Add recipients to "%name"'|i18n( 'design/admin/jaj_newsletter/newsletter_add_recipients',, hash("%name", $node.name) )|wash()}</h1>
			<div class="header-mainline"></div>
		</div>
	</div>
	
	<div class="block" style="display: none">
		<p>
			{'Select the subscription lists you want to send this newsletter to.'|i18n( 'design/admin/jaj_newsletter/newsletter_add_recipients' )}
		</p>
	</div>

	<div class="box-content">
		<table class="list" cellspacing="0" summary="">
		<tr>
			<th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} onclick="ezjs_toggleCheckboxes( document.subscription_lists, 'SubscriptionListIdArray[]' ); return false;"/></th>
    		<th>{'Subscription List'|i18n( 'design/admin/jaj_newsletter/newsletter_add_recipients' )}</th>
    		<th>{'Active Recipients'|i18n( 'design/admin/jaj_newsletter/newsletter_add_recipients' )}</th>
		</tr>
			
		{foreach $lists as $list sequence array( 'bglight', 'bgdark' ) as $sequence}			
		<tr class="{$sequence}">
			<td class="tight"><input type="checkbox" name="SubscriptionListIdArray[]" value="{$list.id}" {if $active_list_ids|contains($list.id)}checked="checked" {/if}/></td>
 			<td>
   				<a href={concat( 'jaj_newsletter/list/', $list.id)|ezurl}>{$list.name|wash}</a>
			</td>
   			<td>
   				{$list.active_subscribers_count}
   				{$list.has_recipients_list_for_content_object_id(2)} 				
			</td>
		</tr>
		{/foreach}
		</table>
	</div>
	
	<div class="block">
		<div class="controlbar subitems-controlbar">					
			<div class="block">    					
				<div class="button-left">
					<input class="defaultbutton" type="submit" name="StoreButton" value="{'Store'|i18n( 'design/admin/jaj_newsletter/newsletter_add_recipients' )}" />
					<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'design/admin/jaj_newsletter/newsletter_add_recipients' )}" />
				</div>
				<div class="float-break"></div>
			</div>
		</div>
	</div>		
</form>