	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{$node.name|wash()}</h1>
			<div class="header-mainline"></div>
		</div>
	</div>

	{if $error_strings|count()}
	<div class="message-error">
		<h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {'Error'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</h2>
		{foreach $error_strings as $line}
			<p>{$line|wash()}</p>
		{/foreach}
	</div>
	{/if}
	
	{if $feedback_strings|count()}
	<div class="message-feedback">
		<h2><span class="time">[{currentdate()|l10n( shortdatetime )}]</span> {'Info'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</h2>
		{foreach $feedback_strings as $line}
			<p>{$line|wash()}</p>
		{/foreach}
	</div>	
	{/if}

	<div class="tab-block">
		<ul class="tabs">
			{def $class="first"}
			{foreach $tabs as $key => $value}
			{if $selected_tab|eq($key)}
				{set $class=concat($class, ' selected')}
			{/if}
			<li class="{$class}">
				<a href={concat( 'jaj_newsletter/newsletter/', $node.main_node_id, '/(tab)/', $key )|ezurl}>{$value|i18n( 'design/admin/jaj_newsletter/newsletter' )}</a> 				
			</li>
			{set $class="middle"}
			{/foreach}		
			{undef $class}					
		</ul>
		
		<div class="float-break"></div>
			
		{if $selected_tab|eq('details')}
		<div class="tab-content selected">
			<div class="block">
				<table class="list">
					<tr>
						<th>{'Subject'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
						<th>{'From'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
						<th>{'Reply-to'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
						<th>{'Status'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
					</tr>
					<tr>
						<td>{attribute_view_gui attribute=$node.data_map.subject}</td>
						<td>{$from_email|wash()} ({$from_name|wash()})</td>
						<td>{$reply_email|wash()}</td>
						<td>{$node.data_map.status.content|upword()|i18n( 'design/admin/jaj_newsletter/newsletters' )|wash()}</td>
					</tr>
				</table>
				<label></label>
			</div>
			
			<div class="block">
				<fieldset>
					<legend>{$node.data_map.pretext.contentclass_attribute.name|wash()}</legende>
					
					{attribute_view_gui attribute=$node.data_map.pretext}
				</fieldset>
			</div>
			
			<div class="block">
				<fieldset>
					<legend>{$node.data_map.topics.contentclass_attribute.name|wash()}</legend>
					{attribute_view_gui attribute=$node.data_map.topics}
				</fieldset>
			</div>
	
			<div class="block">
				<fieldset>
					<legend>{$node.data_map.posttext.contentclass_attribute.name|wash()}</legend>	
					{attribute_view_gui attribute=$node.data_map.posttext}
				</fieldset>
			</div>
		</div>
		{elseif $selected_tab|eq('preview_html')}
			<iframe class="tab-content selected" style="height: 20em" src={concat('/jaj_newsletter/preview/', $node.main_node_id)|ezurl()} width="100%"></iframe>
		{elseif $selected_tab|eq('preview_text')}
			<iframe class="tab-content selected" style="height: 20em" src={concat('/jaj_newsletter/preview/', $node.main_node_id, '/(mode)/text')|ezurl()} width="100%"></iframe>
		{/if}
	</div>
	
	<div class="controllbar">
		<div class="button-left">
			<div class="block">
				{if $node.can_edit}
    				<form action="/content/action" method="post" style="display:inline">
    					<input type="hidden" name="TopLevelNode" value="{$node.main_node_id}" />
						<input type="hidden" name="ContentNodeID" value="{$node.main_node_id}" />
						<input type="hidden" name="ContentObjectID" value="{$node.id}" />
    					<input type="hidden" name="ContentObjectLanguageCode" value="{fetch( 'content', 'prioritized_languages' )[0].locale}" />
    					<input type="hidden" name="RedirectURIAfterPublish" value={concat( 'jaj_newsletter/newsletter/', $node.main_node_id)|ezurl} />
    					<input type="hidden" name="RedirectIfDiscarded" value={concat( 'jaj_newsletter/newsletters/', $node.main_node_id)|ezurl} />
    					<input type="submit" name="EditButton"  value="{'Edit'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" class="button" />
    				</form>
    			{else}
					<input class="button-disabled" value="{'Edit'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" type="submit" />
    			{/if}
    			
    			<form action={concat("/jaj_newsletter/newsletter_send/", $node.id )|ezurl} method="post" style="display: inline">
				{if and( $node.data_map.status.content.0|eq(0), $total_recipients ) }
					<input class="button" name="SendNewsletter" value="{'Send'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" type="submit" />
				{elseif $node.data_map.status.content.0|eq(2)}
					<input class="button" name="SendNewsletter" value="{'Resend'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" type="submit" />
				{else}
					<input class="button-disabled" value="{'Send'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" type="submit" disabled="disabled" />				
				{/if}
				</form>
			</div>
		</div>
		
		<div class="button-right">
			<div class="block">
				<form action={concat("/jaj_newsletter/preview/", $node.main_node_id )|ezurl} method="post">
					<input name="EmailAddress" type="text" value="{fetch( 'user', 'current_user' ).email}" />
					<input name="SendPreview" type="submit" class="button" value="{'Send Preview'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" />
				</form>
			</div>
		</div>
		<div class="float-break"></div>
	</div>
	
	<div class="box-header">
		<h2 class="context-title">{'Recipients'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</h2>
		<div class="header-mainline"></div>
	</div>
	
	{if $total_recipients}
	<br />	
	<div class="box-content">
		<table class="list" cellspacing="0" summary="">
		<tr>
    		<th>{'Subscription List'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
    		<th>{'Active Recipients'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
       		<th class="tight">&nbsp;</th>
		</tr>
			
		{foreach $recipients_lists as $list sequence array( 'bglight', 'bgdark' ) as $sequence}			
		<tr class="{$sequence}">
 			<td>
   				<a href={concat( 'jaj_newsletter/list/', $list.subscription_list.id)|ezurl}>{$list.subscription_list.name|wash}</a>
			</td>
   			<td>
   				{$list.subscription_list.active_subscribers_count} 				
			</td>
   			<td>
   				<form action={concat("/jaj_newsletter/newsletter_add_recipients/", $node.id )|ezurl} method="post">
   					<input type="hidden" name="SubscriptionListID" value="{$list.subscription_list.id}" />
	   				<input type="image" src={'remove.png'|ezimage} width="16" height="16" name="RemoveRecipientsList" />
				</form>
   			</td>
		</tr>
		{/foreach}
		
		<tr class="{$sequence}">
			<th>{'Total'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
			{def $unique=fetch( 'jaj_newsletter', 'newsletter_recipients_count', hash( 'status', 'active', 'object_id', $node.id ) )}
			<th>{'%total - %unique unique'|i18n( 'design/admin/jaj_newsletter/newsletter',, hash('%total', $total_active_recipients, '%unique', $unique) )}</th>
			{undef $unique}
   			<th></th>
		</tr>
				
		</table>
	</div>	
	{/if}

	<div class="block">
		<div class="controlbar subitems-controlbar">					
			<div class="block">    					
				<div class="button-left">
					<form action={concat("/jaj_newsletter/newsletter_add_recipients/", $node.id )|ezurl} method="post">
						<input class="button" type="submit" name="AddRecipientsButton" value="{'Add Recipients'|i18n( 'design/admin/jaj_newsletter/newsletter' )}" />
					</form>
				</div>
				<div class="float-break"></div>
			</div>
		</div>
	</div>		
	
	<div class="box-header">
		<h2 class="context-title">{'Delivery'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</h2>
		<div class="header-mainline"></div>
	</div>

	{if $deliveries|count()}

	<div class="context-toolbar">
		<div class="button-left">
			<p class="table-preferences">
				{foreach array(10,25,50) as $limit}
					{if $limit|eq($set_limit)}
						<span class="current">{$limit}</span>
					{else}
						<a href="/user/preferences/set/admin_jaj_newsletter_newsletter_view_limit/{$limit}">{$limit}</a>
					{/if}
				{/foreach}			
			</p>			
		</div>
		<div class="float-break"></div>
	</div>		
	
	<div class="box-content">
		<table class="list" cellspacing="0" summary="">
		<tr>
    		<th>{'E-mail'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
    		<th>{'Status'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
    		<th>{'Sent'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
    		<th>{'Opened in e-mail client'|i18n( 'design/admin/jaj_newsletter/newsletter' )} *</th>        		    		
    		<th>{'Viewed online'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</th>
    		<th class="tight">&nbsp;</th>   
		</tr>
			
		{foreach $deliveries as $delivery sequence array( 'bglight', 'bgdark' ) as $sequence}			
		<tr class="{$sequence}">
   			<td>
   				{$delivery.email|wash}
			</td>
   			<td>
   				{$delivery.state|upword()|i18n( 'design/admin/jaj_newsletter/newsletter' )|wash}			
			</td>
			<td>
				{if $delivery.sent} {$delivery.sent|l10n( shortdatetime )} {/if}
			</td>
   			<td>
				{if $delivery.opened} {$delivery.opened|l10n( shortdatetime )} {/if}   			
   			</td>
   			<td>
				{if $delivery.viewed} {$delivery.viewed|l10n( shortdatetime )} {/if}   			
   			</td>
   			<td class="tight">
   				<a href="#">
   					<a href={concat( "http://", ezini( 'SiteSettings', 'SiteURL' ), "/", $node.main_node.url_alias, "/(preview)/nl/(uuid)/", $delivery.uuid)|ezurl()} target="_blank">
						<img src={'window_fullscreen.png'|ezimage} />
					</a>
   				</a>
   			</td>
		</tr>
		{/foreach}
		</table>
	</div>

	{* Navigator. *}
	<div class="context-toolbar subitems-context-toolbar">
			{include name=navigator
	       	uri='design:navigator/google.tpl'
	       	page_uri=concat( 'jaj_newsletter/newsletter/', $node.main_node_id, $view_state )
	        item_count=$deliveries_count
	        view_parameters=$view_parameters
	        item_limit=$set_limit}
	</div>	
	{/if}
	
	<div class="block" style="float:right">
		<p><strong>*</strong> {'Only an estimate'|i18n( 'design/admin/jaj_newsletter/newsletter' )}</p>
	</div>
