<form action={concat( 'jaj_newsletter/list_add/', $list.id)|ezurl} method="post" >
	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{'Add new subscribers'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}</h1>
			<div class="header-mainline"></div>
		</div>
	</div>
	<div class="context-block">
		<div class="box-header">
			<h2 class="context-title">{'Enter each subscriber on a separate line (up to 200 lines)'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}</h2>
			<div class="header-mainline"></div>
		</div>
	</div>	
	<div class="box-content">
		<p>
			Each line must contain an email address. You can allso include a name which must be separated by a comma.			
		</p>
	</div>
	{if $messages}
		<div class="context-block">
			<div class="box-header">
				<h2 class="context-title">					
					{'List imported, please review result'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}:
				</h2>
				<div class="header-mainline"></div>
			</div>
			{if $messages.add}
			<fieldset style="background-color: #DFF2BF">
				{if $messages.add|gt(1)}
					{'%count subscribers were added'|i18n( 'design/admin/jaj_newsletter/list_add',,hash('%count',$messages.add))|wash}
				{else}
					{'1 subscriber was added'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}
				{/if}				
			</fieldset>	
			{/if}
			{if $messages.update}
			<fieldset style="background-color: #BDE5F8">
				{if $messages.update|gt(1)}
					{'%count subscribers were updated'|i18n( 'design/admin/jaj_newsletter/list_add',,hash('%count',$messages.update))|wash}
				{else}
					{'1 subscriber was updated'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}
				{/if}				
			</fieldset>	
			{/if}
			{if $messages.ignore}
			<fieldset style="background-color: #FEEFB3">
				{if $messages.ignore|gt(1)}
					{'%count subscribers already exists and were ignored'|i18n( 'design/admin/jaj_newsletter/list_add',,hash('%count',$messages.ignore))|wash}
				{else}
					{'1 subscriber already exsist and was ignored'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}
				{/if}					
			</fieldset>	
			{/if}						
			{if $messages.invalid}
			<fieldset style="background-color: #FFBABA">
				{if $messages.invalid|gt(1)}
					{'%count lines could not be parsed and were ignored, please review the lines below'|i18n( 'design/admin/jaj_newsletter/list_add',,hash('%count',$messages.invalid))|wash}
				{else}
					{'1 line could not be parsed and was ignored, please review the line bellow'|i18n( 'design/admin/jaj_newsletter/list_add')|wash}
				{/if}
			</fieldset>	
			{/if}		
		</div>
	{/if}
	<div class="box-content">
		<fieldset>
			<textarea style="width: 99%;" name="SubscribersList" rows="10">{$subscribers|wash()}</textarea>
		</fieldset>			
	</div>
	
	<div class="block">
		<div class="controlbar">					
			<div class="block">    					
				<div class="button-left">
					<input class="defaultbutton" type="submit" name="StoreButton" value="{'Add subscribers'|i18n( 'design/admin/jaj_newsletter/list_add' )}" />
					<input class="button" type="submit" name="CancelButton" value="{'Cancel'|i18n( 'design/admin/jaj_newsletter/list_add' )}" />
				</div>
				<div class="float-break"></div>
			</div>
		</div>
	</div>
</form>
