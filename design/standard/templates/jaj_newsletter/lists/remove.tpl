<form action={concat("/jaj_newsletter/list_remove", cond($list.id,concat('/',$list.id),true(),''))|ezurl} method="post">
    <div class="message-warning">
    <h2>
    	<span class="time">[{currentdate()|l10n( shortdatetime )}]</span>
    	{'Confirm deletion of Subscription List "%list_name"'|i18n( 'design/admin/jaj_newsletter/list_remove', '', hash( '%list_name', $list.name ))|wash()}</h2>
    <p>{'Please consider'|i18n( 'design/admin/jaj_newsletter/list_remove' )}:</p>
    <ul>
    	<li><strong>{'%count subscribers belonging to this list will be deleted'|i18n( 'design/admin/jaj_newsletter/list_remove', '', hash( '%count', $list.subscribers_count ) )}</strong></li>
    	<li>{'This action can not be undone!'|i18n( 'design/admin/jaj_newsletter/list_remove' )}</li>
    </ul>
    </div>
    
<div class="context-block">
	<div class="block">
		<div class="controlbar">					
			<div class="block">    					
				<div class="button-left">
					<input class="defaultbutton" type="submit" name="ConfirmButton" value="{'Confirm'|i18n( 'design/admin/jaj_newsletter/list_remove' )}" />
					<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'design/admin/jaj_newsletter/list_remove' )}" />
				</div>
				<div class="float-break"></div>
			</div>
		</div>
	</div>
</div>
</form>