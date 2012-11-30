{if is_set($image_class)|not()}
	{def $image_class='thumbnail'}
{/if}

<tr class="newsletter-topic">
	<td class="topic-image">
		{if $node.data_map.image.content}
			{attribute_view_gui href=$node.data_map.location.content|ezurl() image_class=$image_class attribute=$node.data_map.image.content.data_map.image}
		{/if}
	</td>
	<td class="topic-content-attributes">
		<h2><a href={$node.data_map.location.content|ezurl()}>{$node.name|wash}</a></h2>
		 <div class="attribute-intro">
		 	{attribute_view_gui attribute=$node.data_map.intro}
	     </div>
	     <div class="attribute-link">
	     	<a href="{$node.data_map.location.content}"><span>{if $node.data_map.location.data_text|count|gt( 0 )}{$node.data_map.location.data_text|wash}{else}{$node.data_map.location.content|wash}{/if}</span></a>
	     </div>
	</td>
</tr>

{undef $image_class}