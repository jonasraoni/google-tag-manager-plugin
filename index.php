<?php

/**
 * @defgroup plugins_generic_googleTagManager Google Tag Manager Plugin
 */

/**
 * @file plugins/generic/googleTagManager/index.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_googleTagManager
 * @brief Wrapper for Google Tag Manager plugin.
 *
 */

require_once 'GoogleTagManagerPlugin.inc.php';

return new PKP\Plugins\Generic\GoogleTagManager\GoogleTagManagerPlugin();
