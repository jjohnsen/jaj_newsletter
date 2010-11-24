{if and($view_parameters.uuid)}
	{def $delivery=fetch( 'jaj_newsletter', 'newsletter_delivery_by_object_id_and_uuid', hash( 'object_id', $node.contentobject_id, 'uuid', $view_parameters.uuid ) )}
{/if}
{def $params=""}

<html>
<head>
    <!-- meta http-equiv="Content-Type" content="text/html; charset=utf-8" -->
    <title>{$node.data_map.subject.content|wash()}</title>
    <link rel="stylesheet" media="screen" type="text/css" href={"stylesheets/newsletter.css"|ezdesign}/>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center">
            <table id="main" width="580" border="0" cellspacing="0" cellpadding="0">
            
            {if or( $view_parameters.generate, $view_parameters.preview )}
            {if $view_parameters.generate}
            	{set $params=concat('/(view)/nl/(uuid)/', $delivery.uuid)}
            {/if}
            <tr>
                <td id="webversion" align="center">
                    <p>
                        {'Having trouble viewing this email?'|i18n( 'design/standard/override/templates/full/jaj_newsletter' )}
                        <a href={concat($node.url_alias, $params)|ezurl()}>{'View it in your browser'|i18n( 'design/standard/override/templates/full/jaj_newsletter')}</a>
                    </p>
               </td>
            </tr>
            {/if}
            
            <tr>
                <td>
                    <table width="580" border="0" cellspacing="16" cellpadding="0" id="content">
                    <tr class="header">
                        <td>
                        <table width="580" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                        <td class="subject">
                            <h1>{$node.data_map.subject.content|wash()}</h1>
                        </td>
                        <td align="right">
                            {def $pagedesign=fetch_alias(by_identifier,hash(attr_id,sitestyle_identifier))}
                                <a href={"/"|ezurl}><img 
                                    src={$pagedesign.data_map.image.content[original].full_path|ezroot} 
                                    alt="{$pagedesign.data_map.image.content[original].text}" /></a>
                            {undef $pagedesign}
                        </td>
                        </tr>
                        </table>
                        </td>
                    </tr>

                    {if $node.data_map.pretext.has_content}
                    <tr class="pretext">
                        <td>
                            {attribute_view_gui attribute=$node.data_map.pretext}
                        </td>
                    </tr>
                    {/if}

                    {foreach $node.data_map.topics.content.relation_list as $index => $relation}
                    {def $topic=fetch( 'content', 'node', hash( 'node_id', $relation.node_id ) )}
                    <tr class="topic">
                        <td>
                            {node_view_gui view=line content_node=$topic}
                        </td>
                    </tr>
                    {undef $topic}
                    {/foreach}

                    {if $node.data_map.posttext.has_content}
                    <tr class="posttext">
                        <td>
                            {attribute_view_gui attribute=$node.data_map.posttext}
                        </td>
                    </tr>
                    {/if}
                    </table>
                </td>
            </tr>
            
            {if or( is_object($delivery), $view_parameters.preview )}
            {if is_object($delivery)}
            	{set $params=$delivery.uuid}
            {/if}
            <tr>
            	<td align="center">
                    <p>
                        {'To unsubscribe from this newsletter, just click on the following link:'|i18n( 'design/standard/override/templates/full/jaj_newsletter')}<br />
                        <a href={concat('/jaj_newsletter/unsubscribe/', $params)|ezurl}>{concat('/jaj_newsletter/unsubscribe/', $delivery.uuid)|ezurl('no', 'full')}</a>
                    </p>
               </td>
			</tr>
			{/if}
			
            {if $view_parameters.generate}
            	{set $params=concat($node.contentobject_id, '/', $delivery.uuid)}
            {elseif $view_parameters.view}
            	{set $params=concat($node.contentobject_id, '/', $delivery.uuid, '/view')}            
            {/if}			
			<tr>
				<td align="center">
               		<p>
               			{'Newsletter module by:'|i18n( 'design/standard/override/templates/full/jaj_newsletter')}
               			<img src={concat('/jaj_newsletter/track/', $params)|ezurl()} align="top" alt="Hålogaland ikt" title="Hålogaland ikt" />
               		</p>
				</td>
            </tr>
            </table>
        </td>
    </tr>
    </table>
</body>
</html>