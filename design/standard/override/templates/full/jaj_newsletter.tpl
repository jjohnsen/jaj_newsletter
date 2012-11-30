{if and($view_parameters.uuid)}
    {def $delivery=fetch( 'jaj_newsletter', 'newsletter_delivery_by_object_id_and_uuid', hash( 'object_id', $node.contentobject_id, 'uuid', $view_parameters.uuid ) )}
{/if}
{def $params=""}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="no-bokmaal" lang="no-bokmaal">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$node.data_map.subject.content|wash()}</title>
    <link rel="stylesheet" media="screen" type="text/css" href={"stylesheets/newsletter.css"|ezdesign} />
</head>
<body>
    <div class="newsletter-info">
        {if or( $view_parameters.generate, $view_parameters.preview )}
            {if $view_parameters.generate}
                {set $params=concat('/(view)/nl/(uuid)/', $delivery.uuid)}
            {/if}

            {'Having trouble viewing this email?'|i18n( 'design/standard/override/templates/full/jaj_newsletter' )}
            <a href={concat($node.url_alias, $params)|ezurl()}>{'View in your browser'|i18n( 'design/standard/override/templates/full/jaj_newsletter')}</a>
        {/if}
    </div>

    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">

            <table id="newsletter" width="600" border="0" cellspacing="0" cellpadding="0">
            <tr id="newsletter-header">
                <td>
	                {def $pagedesign=fetch_alias(by_identifier,hash(attr_id,sitestyle_identifier))}
                	{if and($pagedesign.data_map.newsletter_logo, $pagedesign.data_map.newsletter_logo.has_content)}
                		{attribute_view_gui attribute=$pagedesign.data_map.newsletter_logo href=ezurl("/") image_class='original'}
                	{else}
                		{attribute_view_gui attribute=$pagedesign.data_map.image href=ezurl("/") image_class='original'}
                	{/if}
                    {undef $pagedesign}        
                </td>
            </tr>
            <tr>
            	<td id="newsletter-content-wrapper">
            	
            	<table id="newsletter-content" width="100%" border="0" cellspacing="0" cellpadding="0">
            	
	            {if $node.data_map.image.has_content}
                <tr>
                	<td>{attribute_view_gui attribute=$node.data_map.image.content.data_map.image href=ezurl("/") image_class='newsletter'}</td>
                </tr>
                {/if}
                
                {if $node.data_map.pretext.has_content}
                <tr id="newsletter-pretext">
	                <td colspan="2">
                    	<div class="attribute-pretext">
                        	{attribute_view_gui attribute=$node.data_map.pretext}
                        </div>
                    </td>
                </tr>
                {/if}
                
                <tr id="newsletter-topics">
                	<td>
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	                    {foreach $node.data_map.topics.content.relation_list as $index => $relation}
	                    	{def $topic=fetch( 'content', 'node', hash( 'node_id', $relation.node_id ) )}
	                        {node_view_gui view=newsletter content_node=$topic}
	                        <tr class="newsletter-topic-separator">
		                    	<td colspan="2">

		                    	</td>
			                </tr>
			                {undef $topic}
			            {/foreach}
                        </table>
                    </td>
                </tr>
                
                {if $node.data_map.posttext.has_content}
                <tr id="newsletter-posttext">
                	<td>
                    	<div class="attribute-posttext">
	                    	{attribute_view_gui attribute=$node.data_map.posttext}
                        </div>
                    </td>
                </tr>
                {/if}
                </table>
            	
            	</td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
    
    <div class="newsletter-info">
        {if or( is_object($delivery), $view_parameters.preview )}
            {if is_object($delivery)}
                {set $params=$delivery.uuid}
            {/if}
            <p>
                {'To unsubscribe from this newsletter, just click on the following link:'|i18n( 'design/standard/override/templates/full/jaj_newsletter')}<br />
                <a href={concat('/jaj_newsletter/unsubscribe/', $params)|ezurl}>{concat('/jaj_newsletter/unsubscribe/', $delivery.uuid)|ezurl('no', 'full')}</a>
            </p>
        {/if}

        {if $view_parameters.generate}
            {set $params=concat($node.contentobject_id, '/', $delivery.uuid)}
        {elseif $view_parameters.view}
            {set $params=concat($node.contentobject_id, '/', $delivery.uuid, '/view')}
        {/if}
        <p>
            {'Newsletter module by:'|i18n( 'design/standard/override/templates/full/jaj_newsletter')}
            <a href="http://www.hikt.no/(nh)"><img src={concat('/jaj_newsletter/track/', $params)|ezurl()} align="top" alt="Hålogaland ikt" title="Hålogaland ikt" /></a>
        </p>
    </div>

    </body>
</html>