<?php

/**
 * @file plugins/generic/sanguMostViewed/SanguMostViewedSettingsForm.php
 *
 * Copyright (c) 2024 Sangu
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SanguMostViewedSettingsForm
 *
 * @brief Form for journal managers to modify Sangu Most Viewed plugin settings.
 */

namespace APP\plugins\generic\sanguMostViewed;

use APP\template\TemplateManager;
use PKP\form\Form;
use PKP\form\validation\FormValidatorPost;
use PKP\form\validation\FormValidatorCSRF;

class SanguMostViewedSettingsForm extends Form
{
    /** @var int */
    public $_contextId;

    /** @var SanguMostViewedPlugin */
    public $_plugin;

    /**
     * Constructor
     *
     * @param SanguMostViewedPlugin $plugin
     * @param int $contextId
     */
    public function __construct($plugin, $contextId)
    {
        $this->_contextId = $contextId;
        $this->_plugin = $plugin;

        parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));

        $this->addCheck(new FormValidatorPost($this));
        $this->addCheck(new FormValidatorCSRF($this));
    }

    /**
     * Initialize form data.
     */
    public function initData()
    {
        $this->_data = [
            'timePeriod' => $this->_plugin->getSetting($this->_contextId, 'timePeriod') ?: 'lifetime',
            'articleCount' => $this->_plugin->getSetting($this->_contextId, 'articleCount') ?: 5,
        ];
    }

    /**
     * Assign form data to user-submitted data.
     */
    public function readInputData()
    {
        $this->readUserVars(['timePeriod', 'articleCount']);
    }

    /**
     * @copydoc Form::fetch()
     *
     * @param null|mixed $template
     */
    public function fetch($request, $template = null, $display = false)
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->_plugin->getName());
        $templateMgr->assign('timePeriodOptions', [
            'last7days' => __('plugins.generic.sanguMostViewed.settings.timePeriod.last7days'),
            'last30days' => __('plugins.generic.sanguMostViewed.settings.timePeriod.last30days'),
            'last1year' => __('plugins.generic.sanguMostViewed.settings.timePeriod.last1year'),
            'lifetime' => __('plugins.generic.sanguMostViewed.settings.timePeriod.lifetime'),
        ]);
        $templateMgr->assign('articleCountOptions', [
            3 => '3',
            5 => '5',
            10 => '10',
            15 => '15',
            20 => '20',
        ]);
        return parent::fetch($request, $template, $display);
    }

    /**
     * @copydoc Form::execute()
     */
    public function execute(...$functionArgs)
    {
        $this->_plugin->updateSetting($this->_contextId, 'timePeriod', $this->getData('timePeriod'), 'string');
        $this->_plugin->updateSetting($this->_contextId, 'articleCount', (int) $this->getData('articleCount'), 'int');
        parent::execute(...$functionArgs);
    }
}

if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\generic\sanguMostViewed\SanguMostViewedSettingsForm', '\SanguMostViewedSettingsForm');
}
