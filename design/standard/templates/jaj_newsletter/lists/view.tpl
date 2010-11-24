<form name="subscribers" action={concat( 'jaj_newsletter/list/', $list.id, '/', $view_state )|ezurl} method="post" >
	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{$list.name|wash()}</h1>
			<div class="header-mainline"></div>
		</div>
		
		<div class="tab-block">
			<ul class="tabs">
				<li class="first selected" id="node-tab-details">
					<a href="#">{'Details'|i18n( 'design/admin/jaj_newsletter/list' )}</a>
				</li>
				<li class="middle" id="node-tab-activity" style="display:none">
					<a href="#/(tab)/activity">{'Activity'|i18n( 'design/admin/jaj_newsletter/list' )}</a>
				</li>				
			</ul>
			<div class="float-break"></div>
			
			<div class="tab-content selected" id="node-tab-adetails-content">
				<div class="block" style="display:none">
					<label>{'List Type'|i18n( 'design/admin/jaj_newsletter/list' )}</label>
					{if $list.confirmation_required}
						{'Confirmed opt-in (confirmation required)'|i18n( 'design/admin/jaj_newsletter/list' )}
					{else}
						{'Single opt-in (no confirmation required)'|i18n( 'design/admin/jaj_newsletter/list' )}
					{/if}
					<p>
						<em>
						Single opt-in means new subscribers are added as active as soon as the complete the subscription form.
						Confirmed opt-in means that a confirmation email is sent when they subscribe, and they must click a validation link to confirm their subscription.
						When you add subscribers manually no confirmation is needed.
						</em>
					</p>
				</div>
				<div class="block">
					<label>{'Subscription URL'|i18n( 'design/admin/jaj_newsletter/list' )}</label>
					<a href={$list.subscribe_url|ezurl()}>{$$list.subscribe_url|wash()}</a>
					{*SiteSettings SiteURL*}
				</div>
				{*
				<div class="block">
					<label>{'Unsubscribe URL'|i18n( 'design/admin/jaj_newsletter/list' )}</label>
					{$list.unsubscribe_url|wash}
				</div>
				*}				
			</div>
			<div class="tab-content hide" id="node-tab-activity-content">
				Activity
			</div>
		</div>
		
		<div class="controllbar" style="display:none">
			<div class="button-left">
				<div class="block">
					<form action="/jaj_newsletter/list_edit/19" style="display:inline">
    					<input type="submit" name="EditButton"  value="{'Edit'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" class="button" />
    				</form>
				</div>
			</div>
			<div class="float-break"></div>
		</div>

		<div class="box-header">
			<h2 class="context-title">{'Subscribers (%count)'|i18n( 'design/admin/jaj_newsletter/list',, hash('%count', $item_count) )}</h2>
			<div class="header-mainline"></div>
		</div>		
		<div class="context-toolbar">
			<div class="button-left">
				<p class="table-preferences">
					{def limits=array(10,25)}
					{foreach array(10,25,50) as $limit}
						{if $limit|eq($set_limit)}
							<span class="current">{$limit}</span>
						{else}
							<a href="/user/preferences/set/admin_jaj_newsletter_subscription_list_limit/{$limit}">{$limit}</a>
						{/if}
					{/foreach}
					{undef $limits}					
				</p>			
			</div>
			<div class="float-break"></div>
		</div>	
				
		<div class="tab-block">
			<ul class="tabs">
				{foreach $subscriber_states as $state}
				{if $state.first}
					{def $class="first"}
				{else}
					{def $class="middle"}
				{/if}
				{if $state.selected}
					{set $class=concat($class, ' selected')}
				{/if}
				<li class="{$class}">
					<a href={concat( 'jaj_newsletter/list/', $list.id, '/', $state.id)|ezurl}>{$state.name|i18n( 'design/admin/jaj_newsletter/list' )} ({$state.count})</a> 				
				</li>
				{undef $class}
				{/foreach}				
			</ul>
			<div class="float-break"></div>
		</div>
		
		<div class="box-content">
			<table class="list" cellspacing="0" summary="">
			<tr>
    			<th class="tight"><img src={'toggle-button-16x16.gif'|ezimage} onclick="ezjs_toggleCheckboxes( document.subscribers, 'SubscriberUUIDArray[]' ); return false;"/></th>
    			<th>{'Email address'|i18n( 'design/admin/jaj_newsletter/list' )}</th>
    			<th>{'Name'|i18n( 'design/admin/jaj_newsletter/list' )}</th>
    			<th>{'Subscribed'|i18n( 'design/admin/jaj_newsletter/list' )}</th>
			</tr>
			
			{foreach $subscribers as $subscriber sequence array( 'bglight', 'bgdark' ) as $sequence}			
			<tr class="{$sequence}">
    			<td class="tight"><input type="checkbox" name="SubscriberUUIDArray[]" value="{$subscriber.uuid}" /></td>
    			<td>
    				{$subscriber.email|wash}
				</td>
    			<td>
    				{$subscriber.name|wash}    				
				</td>
				<td>
					{$subscriber.subscribed|l10n( shortdatetime )}
				</td>
				{*
    			<td>
    				<a href={concat( 'jaj_newsletter/subscriber_edit/', $list.id )|ezurl}><img src={'edit.gif'|ezimage} width="16" height="16" /></a>
				</td>
				*}
			</tr>
			{/foreach}
			</table>
		</div>	
		
		{* Navigator. *}
		<div class="context-toolbar subitems-context-toolbar">
				{include name=navigator
	         	uri='design:navigator/google.tpl'
	         	page_uri=concat( 'jaj_newsletter/list/', $list.id, '/', $view_state )
	         	item_count=$item_count
	         	view_parameters=$view_parameters
	         	item_limit=$set_limit}
		</div>

		<div class="controlbar subitems-controlbar">					
			<div class="block">    					
				<div class="button-left">
					{if $view_state|eq('active')}
					<input class="button" type="submit" name="DeleteSubscribersButton" value="{'Delete selected'|i18n( 'design/admin/jaj_newsletter/list' )}" />
					<input class="button" type="submit" name="UnsubscribeSubscribersButton" value="{'Unsubscribe selected'|i18n( 'design/admin/jaj_newsletter/list' )}" />
					{elseif $view_state|eq('deleted')}
					<input class="button" type="submit" name="UndeleteSubscribersButton" value="{'Activate selected'|i18n( 'design/admin/jaj_newsletter/list' )}" />						
					{/if}
				</div>
				<div class="float-break"></div>
			</div>
		</div>	
		
		<div class="block">
			<div class="controlbar subitems-controlbar">					
				<div class="block">    					
					<div class="button-left">
						<input class="button" type="submit" name="AddSubscribersButton" value="{'Add new subscribers'|i18n( 'design/admin/jaj_newsletter/list' )}" />
					</div>
					<div class="float-break"></div>
				</div>
			</div>
		</div>		
	</div>
</form>
