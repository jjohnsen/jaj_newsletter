{if is_set($image_class)|not()}
	{def $image_class='thumbnail'}
{/if}

<tr class="newsletter-topic">
	<td class="topic-image" valign="top">
		{if $node.data_map.image.content}
			{attribute_view_gui href=$node.url_alias|ezurl() image_class=$image_class attribute=$node.data_map.image.content.data_map.image}
		{/if}
	</td>
	<td class="topic-content-attributes" valign="top">
		<h2><a href={$node.url_alias|ezurl}>{$node.name|wash}</a></h2>
		 <div class="attribute-intro">
		 	{attribute_view_gui attribute=$node.data_map.intro}
	     </div>
	     <div class="attribute-link">
	     	<a href={$node.url_alias|ezurl}><span>{"Read more"|i18n("jajplain")}</span></a>
	     </div>
	</td>
</tr>

{undef $image_class}