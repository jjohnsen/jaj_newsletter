<form action={concat("/jaj_newsletter/list_edit", cond($list.id,concat('/',$list.id),true(),''))|ezurl} method="post">

{if and( is_set($is_valid), $is_valid|not() )}
    <div class="message-warning">
    <h2>
    	<span class="time">[{currentdate()|l10n( shortdatetime )}]</span>
    	{'The subscription list could not be stored.'|i18n( 'design/admin/jaj_newsletter/list_edit' )}</h2>
    <p>{'Required data is either missing or is invalid'|i18n( 'design/admin/jaj_newsletter/list_edit' )}:</p>
    <ul>
    {foreach $validation_messages as $message}
    <li>{$message|wash}</li>
    {/foreach}
    </ul>
    </div>
{/if}

<div class="context-block">
	<div class="box-header">
		<h1 class="context-title">
			{if $list.id}
			{'Edit Subscription List "%list_name"'|i18n('design/admin/jaj_newsletter/list_edit', '', hash( '%list_name', $list.name ))|wash}
			{else}
			{'New Subscription List'|i18n( 'design/admin/jaj_newsletter/list_edit')|wash}
			{/if}				
		</h1>
		<div class="header-mainline"></div>
	</div>
	
	<div class="box-content">
		<div class="block">
			<label>
				{'Name:'|i18n( 'design/admin/jaj_newsletter/list_edit')|wash}
			</label>
			<input type="text" name="ContentObjectNewsletterSubscriptionList_name" size="80" maxlength="45" value="{$list.name|wash}" />
		</div>
	</div>
	
	<div class="block">
		<div class="controlbar">					
			<div class="block">    					
				<div class="button-left">
					{if $list.id}
					<input class="defaultbutton" type="submit" name="StoreButton" value="{'Save changes'|i18n( 'design/admin/jaj_newsletter/list_edit' )}" />
					{else}
					<input class="defaultbutton" type="submit" name="StoreButton" value="{'Create'|i18n( 'design/admin/jaj_newsletter/list_edit' )}" />
					{/if}
					<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'design/admin/jaj_newsletter/list_edit' )}" />
				</div>
				<div class="float-break"></div>
			</div>
		</div>
	</div>
</div>
</form>