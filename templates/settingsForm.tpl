{**
 * plugins/generic/sanguMostViewed/templates/settingsForm.tpl
 *
 * Copyright (c) 2024 Sangu
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Sangu Most Viewed plugin settings form.
 *}
<script>
	$(function() {ldelim}
		$('#sanguMostViewedSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="sanguMostViewedSettingsForm" method="post" action="{url router=\PKP\core\PKPApplication::ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{csrf}
	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="sanguMostViewedSettingsFormNotification"}

	<div id="description">{translate key="plugins.generic.sanguMostViewed.settings.description"}</div>

	{fbvFormArea id="sanguMostViewedSettingsFormArea"}
		{fbvFormSection title="plugins.generic.sanguMostViewed.settings.timePeriod"}
			{fbvElement type="select" id="timePeriod" from=$timePeriodOptions selected=$timePeriod translate=false}
		{/fbvFormSection}

		{fbvFormSection title="plugins.generic.sanguMostViewed.settings.articleCount"}
			{fbvElement type="select" id="articleCount" from=$articleCountOptions selected=$articleCount translate=false}
		{/fbvFormSection}
	{/fbvFormArea}

	{fbvFormButtons}
</form>
