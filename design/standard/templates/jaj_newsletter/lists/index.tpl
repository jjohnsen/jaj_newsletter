<form action={'jaj_newsletter/lists'|ezurl} method="post" >
	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{'Manage Subscription Lists'|i18n( 'design/admin/jaj_newsletter/lists')|wash}</h1>
			<div class="header-mainline"></div>
		</div>
		
		<div class="box-content">
			<table class="list" cellspacing="0" summary="">
			<tr>
    			<th class="tight"></th>
    			<th>{'Name'|i18n( 'design/admin/jaj_newsletter/lists' )}</th>
    			<th>{'Created'|i18n( 'design/admin/jaj_newsletter/lists' )}</th>
    			<th class="tight">{'Active / Total Subscribers'|i18n( 'design/admin/jaj_newsletter/lists' )}</th>
    			<th class="tight">&nbsp;</th>
    			<th class="tight">&nbsp;</th>
			</tr>
			
			{foreach $lists as $list sequence array( 'bglight', 'bgdark' ) as $sequence}			
			<tr class="{$sequence}">
				<td>
				</td>
    			<td>
    				<a href={concat( 'jaj_newsletter/list/', $list.id)|ezurl}>{$list.name|wash}</a>
				</td>
    			<td>
    				{$list.created|l10n( shortdatetime )}
				</td>
				<td class="right">
					{$list.active_subscribers_count}/{$list.subscribers_count}
				</td>				
    			<td>
    				<a href={concat( 'jaj_newsletter/list_remove/', $list.id )|ezurl}><img class="button" src={'trash.png'|ezimage} width="16" height="16" /></a>
    			</td>
    			<td>
    				<a href={concat( 'jaj_newsletter/list_edit/', $list.id )|ezurl}><img src={'edit.gif'|ezimage} width="16" height="16" /></a>
				</td>

			</tr>
			{/foreach}
			</table>
		</div>
		
		{* Navigator. *}
		<div class="context-toolbar subitems-context-toolbar">
				{include name=navigator
	         	uri='design:navigator/google.tpl'
	         	page_uri=concat( 'jaj_newsletter/lists' )
	         	item_count=$item_count
	         	view_parameters=$view_parameters
	         	item_limit=$set_limit}
		</div>
		
		<div class="block">
			<div class="controlbar subitems-controlbar">					
				<div class="block">    					
					<div class="button-left">
						<input class="button" type="submit" name="NewListButton" value="{'New Subscription List'|i18n( 'design/admin/jaj_newsletter/lists' )}" />
					</div>
					<div class="float-break"></div>
				</div>
			</div>
		</div>		
	</div>
</form>
