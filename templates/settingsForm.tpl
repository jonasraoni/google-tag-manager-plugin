{**
 * plugins/generic/googleTagManager/settingsForm.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * Google Tag Manager plugin settings
 *
 *}
<script>
	$(function() {ldelim}
		// Attach the form handler.
		$('#gaSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
	{rdelim});
</script>

<form class="pkp_form" id="gaSettingsForm" method="post" action="{url router=$smarty.const.ROUTE_COMPONENT op="manage" category="generic" plugin=$pluginName verb="settings" save=true}">
	{csrf}
	{include file="controllers/notification/inPlaceNotification.tpl" notificationId="gaSettingsFormNotification"}

	<div id="description">{translate key="plugins.generic.googleTagManager.manager.settings.description"}</div>

	{fbvFormArea id="webFeedSettingsFormArea"}
		{fbvElement type="text" id="googleTagManagerId" value=$googleTagManagerId label="plugins.generic.googleTagManager.manager.settings.googleTagManagerId"}
	{/fbvFormArea}

	{fbvFormButtons}

	<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</form>
