<?php

/**
 * @file SettingsForm.php
 *
 * Copyright (c) 2021 Simon Fraser University
 * Copyright (c) 2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SettingsForm
 *
 * @ingroup plugins_generic_googleTagManager
 *
 * @brief Form for journal managers to modify Google Tag Manager plugin settings
 */

namespace APP\plugins\generic\googleTagManager;

use APP\template\TemplateManager;
use PKP\form\Form;
use PKP\form\validation\FormValidator;
use PKP\form\validation\FormValidatorCSRF;
use PKP\form\validation\FormValidatorPost;

class SettingsForm extends Form
{
    /**
     * Constructor
     */
    public function __construct(private GoogleTagManagerPlugin $plugin, private int $contextId)
    {
        parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));
        $this->addCheck(new FormValidator($this, 'googleTagManagerId', 'required', 'plugins.generic.googleTagManager.manager.settings.googleTagManagerIdRequired'));
        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));
    }

    /**
     * @copydoc Form::execute()
     */
    public function execute(...$functionArgs)
    {
        $this->plugin->updateSetting($this->contextId, 'googleTagManagerId', trim($this->getData('googleTagManagerId'), "\"\';"), 'string');
        return parent::execute(...$functionArgs);
    }

    /**
     * @copydoc Form::fetch()
     *
     * @param null|mixed $template
     */
    public function fetch($request, $template = null, $display = false): string
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->plugin->getName());
        return parent::fetch($request, $template, $display);
    }

    /**
     * Initialize form data.
     */
    public function initData(): void
    {
        $this->_data = ['googleTagManagerId' => $this->plugin->getSetting($this->contextId, 'googleTagManagerId')];
    }

    /**
     * Assign form data to user-submitted data.
     */
    public function readInputData(): void
    {
        $this->readUserVars(['googleTagManagerId']);
    }
}
