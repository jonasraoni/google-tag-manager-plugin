<?php

/**
 * @file SettingsForm.php
 *
 * Copyright (c) 2021 Simon Fraser University
 * Copyright (c) 2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SettingsForm
 * @ingroup plugins_generic_googleTagManager
 *
 * @brief Form for journal managers to modify Google Tag Manager plugin settings
 */

namespace PKP\Plugins\Generic\GoogleTagManager;

import('lib.pkp.classes.form.Form');

class SettingsForm extends \Form {

	/** @var int */
	private $_contextId;

	/** @var GoogleTagManagerPlugin */
	private $_plugin;

	/**
	 * Constructor
	 */
	public function __construct(GoogleTagManagerPlugin $plugin, int $contextId) {
		$this->_contextId = $contextId;
		$this->_plugin = $plugin;

		parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));

		$this->addCheck(new \FormValidator($this, 'googleTagManagerId', 'required', 'plugins.generic.googleTagManager.manager.settings.googleTagManagerIdRequired'));
		$this->addCheck(new \FormValidatorPost($this));
		$this->addCheck(new \FormValidatorCSRF($this));
	}

	/**
	 * @copydoc Form::execute()
	 */
	public function execute(...$functionArgs) {
		$this->_plugin->updateSetting($this->_contextId, 'googleTagManagerId', trim($this->getData('googleTagManagerId'), "\"\';"), 'string');
		return parent::execute(...$functionArgs);
	}

	/**
	 * @copydoc Form::fetch()
	 */
	public function fetch($request, $template = null, $display = false) : string {
		$templateMgr = \TemplateManager::getManager($request);
		$templateMgr->assign('pluginName', $this->_plugin->getName());
		return parent::fetch($request, $template, $display);
	}

	/**
	 * Initialize form data.
	 */
	public function initData() : void {
		$this->_data = ['googleTagManagerId' => $this->_plugin->getSetting($this->_contextId, 'googleTagManagerId')];
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	public function readInputData() : void {
		$this->readUserVars(['googleTagManagerId']);
	}
}

