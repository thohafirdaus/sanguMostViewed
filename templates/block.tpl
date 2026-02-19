{**
 * plugins/generic/sanguMostViewed/templates/block.tpl
 *
 * Copyright (c) 2024 Sangu
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Sidebar block displaying most viewed articles.
 *}
{if $articles|@count > 0}
<div class="pkp_block block_sangu_most_viewed">
	<h2 class="title">
		{$blockTitle|escape}
	</h2>

	{if $timePeriodLabel}
		<p class="sangu_most_viewed_period">{$timePeriodLabel|escape}</p>
	{/if}

	<div class="content">
		<ol class="sangu_most_viewed_list">
			{foreach from=$articles item=article}
				<li class="sangu_most_viewed_item">
					<a href="{$article.url}" class="sangu_most_viewed_link">
						{$article.title|escape}
					</a>
					<span class="sangu_most_viewed_views">
						({$article.views} {translate key="plugins.block.sanguMostViewed.views"})
					</span>
				</li>
			{/foreach}
		</ol>
	</div>

	<p style="text-align: right; font-size: 9px; margin: 4px 0 0; opacity: 0.6;">
		by <a href="https://sanguilmu.com" target="_blank" rel="noopener">Sangu Ilmu</a>
	</p>
</div><!-- .block_sangu_most_viewed -->
{/if}
