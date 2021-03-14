<?php

/**
 * @file plugins/generic/googleTagManager/GoogleTagManagerPlugin.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class GoogleTagManagerPlugin
 * @ingroup plugins_generic_googleTagManager
 *
 * @brief Google Tag Manager plugin class
 */

namespace PKP\Plugins\Generic\GoogleTagManager;

import('lib.pkp.classes.plugins.GenericPlugin');

class GoogleTagManagerPlugin extends \GenericPlugin {
	/** 
	 * Constructor
	 */
	public function __construct() {
		$this->_useAutoLoader();
	}

	/**
	 * @copydoc Plugin::register()
	 */
	public function register($category, $path, $mainContextId = null) : bool {
		$success = parent::register($category, $path, $mainContextId);
		if (!\Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) {
			return true;
		}
		if ($success && $this->getEnabled($mainContextId)) {
			// Insert Google Tag Manager script
			\HookRegistry::register('TemplateManager::display', function () {
				$this->_registerScript();
				return false;
			});
			// Insert Google Tag Manager fallback
			\HookRegistry::register('Templates::Common::Footer::PageFooter', function ($hook, $args) {
				$args[2] = $this->_getFallback();
				return false;
			});
		}
		return $success;
	}

	/**
	 * Registers a custom autoloader to handle the plugin namespace
	 */
	private function _useAutoLoader () : void {
		spl_autoload_register(function ($className) {
			// Removes the base namespace from the class name
			$path = explode(__NAMESPACE__ . '\\', $className, 2);
			if (!reset($path)) {
				// Breaks the remaining class name by \ to retrieve the folder and class name
				$path = explode('\\', end($path));
				$class = array_pop($path);
				$path = array_map(function ($name) {
					return strtolower($name[0]) . substr($name, 1);
				}, $path);
				$path[] = $class;
				// Uses the internal loader
				$this->import(implode('.', $path));
			}
		});
	}

	/**
	 * @copydoc Plugin::getActions()
	 */
	public function getActions($request, $verb) : array {
		$actions = parent::getActions($request, $verb);
		if ($this->getEnabled()) {
			$router = $request->getRouter();
			import('lib.pkp.classes.linkAction.request.AjaxModal');
			$actions = array_merge([
				new \LinkAction(
					'settings',
					new \AjaxModal(
						$router->url($request, null, null, 'manage', null, ['verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic']),
						$this->getDisplayName()
					),
					__('manager.plugins.settings'),
					null
				),
			], $actions);
		}
		return $actions;
	}

	/**
	 * @copydoc Plugin::manage()
	 */
	public function manage($args, $request) : \JSONMessage {
		if ($request->getUserVar('verb') !== 'settings') {
			return parent::manage($args, $request);
		}

		$context = $request->getContext();
		\AppLocale::requireComponents(\LOCALE_COMPONENT_APP_COMMON,  \LOCALE_COMPONENT_PKP_MANAGER);
		$templateMgr = \TemplateManager::getManager($request);
		$templateMgr->registerPlugin('function', 'plugin_url', [$this, 'smartyPluginUrl']);

		$form = new SettingsForm($this, $context->getId());

		if ($request->getUserVar('save')) {
			$form->readInputData();
			if ($form->validate()) {
				$form->execute();
				return new \JSONMessage(true);
			}
		} else {
			$form->initData();
		}
		return new \JSONMessage(true, $form->fetch($request));
	}

	/**
	 * Register the Google Tag Manager script tag
	 * @param $hookName string
	 * @param $params array
	 */
	public function _registerScript() : void {
		$request = \Application::get()->getRequest();
		if (!$googleTagManagerId = $this->_getGoogleTagManagerId()) {
			return;
		}

		$googleTagManagerCode = "<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer'," . json_encode($googleTagManagerId) . ");</script>";
		$templateMgr = \TemplateManager::getManager($request);
		$templateMgr->addHeader('googletagmanager', $googleTagManagerCode);
	}

	private function _getFallback() : ?string {
		if (!$googleTagManagerId = $this->_getGoogleTagManagerId()) {
			return null;
		}
		return '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . htmlspecialchars($googleTagManagerId) . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
	}

	private function _getGoogleTagManagerId() : ?string {
		$request = \Application::get()->getRequest();
		$router = $request->getRouter();
		$context = $request->getContext();
		if (!$context || !($router instanceof \PKPPageRouter)) {
			return null;
		}
		return $this->getSetting($context->getId(), 'googleTagManagerId') ?: null;
	}

	/**
	 * @copydoc Plugin::getDisplayName()
	 */
	public function getDisplayName() : string {
		return __('plugins.generic.googleTagManager.displayName');
	}

	/**
	 * @copydoc Plugin::getName()
	 */
	public function getName(): string
	{
		$class = explode('\\', __CLASS__);
		return strtolower(end($class));
	}

	/**
	 * @copydoc Plugin::getDescription()
	 */
	public function getDescription() : string {
		return __('plugins.generic.googleTagManager.description');
	}
}
