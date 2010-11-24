{def $items = fetch( 'content', 'list', hash( 
	 		'parent_node_id', $node.main_node_id,
	 		'class_filter_type',  'include',
            'class_filter_array', array( $newsletter_content_class_id ),
            'sort_by', array( 'published', false() ),
			'limit', $set_limit,
			'offset', $view_parameters.offset
	 ))
     $item_count = fetch( 'content', 'list_count', hash(     
     		'parent_node_id', $node.main_node_id,
	 		'class_filter_type',  'include',
            'class_filter_array', array( $newsletter_content_class_id )
     ))
}

	<div class="context-block">
		<div class="box-header">
			<h1 class="context-title">{'Newsletters'|i18n( 'design/admin/jaj_newsletter/newsletters')|wash}</h1>
			<div class="header-mainline"></div>
		</div>
		<div class="context-toolbar">
			<div class="button-left">
				<p class="table-preferences">
					{foreach array(10,25,50) as $limit}
						{if $limit|eq($set_limit)}
							<span class="current">{$limit}</span>
						{else}
							<a href="/user/preferences/set/admin_jaj_newsletter_newsletters_limit/{$limit}">{$limit}</a>
						{/if}
					{/foreach}			
				</p>			
			</div>
			<div class="button-right" style="display:none">
				<p class="table-preferences">
					<span class="current">{'All'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</span>
					<a href="#">{'Draft'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</a>
					<a href="#">{'In Progress'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</a>
					<a href="#">{'Archive'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</a>
				</p>
			</div>
			<div class="float-break"></div>
		</div>	
				
		<div class="box-content">
			<table class="list" cellspacing="0" summary="">
			<tr>
    			<th class="tight"></th>
    			<th>{'Name'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</th>
    			<th>{'Subject'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</th>    		    				
    			<th>{'Modified'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</th>
    			<th>{'Status'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</th>
    			<th class="tight">{'Recipients'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</th>
    			<th class="tight">{'Delivered'|i18n( 'design/admin/jaj_newsletter/newsletters' )}</th>
    			<th class="tight">&nbsp;</th>
    			<th class="tight">&nbsp;</th>   			
			</tr>
			
			{foreach $items as $item sequence array( 'bglight', 'bgdark' ) as $sequence}			
			<tr class="{$sequence}">
				<td>
				</td>
    			<td>
    				<a href={concat( 'jaj_newsletter/newsletter/', $item.node_id)|ezurl}>{$item.name|wash}</a>
				</td>
				<td>
					{attribute_view_gui attribute=$item.data_map.subject}
				</td>
    			<td>
    				{$item.object.modified|l10n( shortdatetime )}
				</td>
				<td>
					{$item.data_map.status.content|upword()|i18n( 'design/admin/jaj_newsletter/newsletters' )|wash()}
				</td>
    			<td class="right">
    				{fetch( 'jaj_newsletter', 'newsletter_recipients_count', hash( 'status', 'active', 'object_id', $item.contentobject_id ) )}
    			</td>
   				<td class="right">
   					{fetch( 'jaj_newsletter', 'newsletter_delivery_count', hash( 'status', 'sent', 'object_id', $item.contentobject_id ) )}
   				</td>
   				<td>
   				</td>   				
    			<td>
    				{if $item.can_edit}
    				<form action="/content/action" method="post">
    					<input type="hidden" name="TopLevelNode" value="{$item.object.main_node_id}" />
						<input type="hidden" name="ContentNodeID" value="{$item.node_id}" />
						<input type="hidden" name="ContentObjectID" value="{$item.contentobject_id}" />
    					<input type="hidden" name="ContentObjectLanguageCode" value="{fetch( 'content', 'prioritized_languages' )[0].locale}" />
    					<input type="hidden" name="RedirectURIAfterPublish" value={concat( 'jaj_newsletter/newsletter/', $item.node_id)|ezurl} />
    					<input type="hidden" name="RedirectIfDiscarded" value={concat( 'jaj_newsletter/newsletters/')|ezurl} />
    					<input type="image" name="EditButton" src={'edit.gif'|ezimage} />
    				</form>
    				{else}
            			<img src={'edit-disabled.gif'|ezimage} alt="{'Edit'|i18n( 'design/admin/node/view/full' )}" title="{'You do not have permission to edit <%child_name>.'|i18n( 'design/admin/node/view/full',, hash( '%child_name', $item.name ) )|wash}" />
    				{/if}
    			</td>
   			</tr>
			{/foreach}
			</table>
		</div>

		{* Navigator. *}
		<div class="context-toolbar subitems-context-toolbar">
				{include name=navigator
	         	uri='design:navigator/google.tpl'
	         	page_uri=concat( 'jaj_newsletter/newsletters', $view_state )
	         	item_count=$item_count
	         	view_parameters=$view_parameters
	         	item_limit=$set_limit}
		</div>
		
		<div class="block">
			<div class="controlbar subitems-controlbar">					
				<div class="block">    					
					<div class="button-left">
						{if $newsletter_content_class_id}
						<form action="/content/action" method="post">
							<input type="hidden" name="NodeID" value="{$node.main_node_id}" />
							<input type="hidden" name="ClassID" value="{$newsletter_content_class_id}" />
							<input type="hidden" name="ContentLanguageCode" value="{fetch( 'content', 'prioritized_languages' )[0].locale}" />
							<input type="hidden" name="RedirectURIAfterPublish" value={concat( 'jaj_newsletter/newsletters/')|ezurl} />
							<input type="hidden" name="RedirectIfDiscarded" value={concat( 'jaj_newsletter/newsletters/')|ezurl} />							
							<input class="button" type="submit" name="NewButton" value="{'New Newsletter'|i18n( 'design/admin/jaj_newsletter/newsletters' )}" />
						</form>
						{else}
							{'Can not find Content Class "jaj_newsletter"'|i18n( 'jaj_newsletter/newsletters' )}
						{/if}
					</div>
					<div class="float-break"></div>
				</div>
			</div>
		</div>		
	</div>