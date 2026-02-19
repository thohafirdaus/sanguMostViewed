<?php

/**
 * @file plugins/generic/sanguMostViewed/SanguMostViewedBlockPlugin.php
 *
 * Copyright (c) 2024 Sangu
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 * @class SanguMostViewedBlockPlugin
 *
 * @brief Block plugin to display most viewed articles in the sidebar.
 */

namespace APP\plugins\generic\sanguMostViewed;

use APP\core\Application;
use APP\facades\Repo;
use APP\submission\Submission;
use Illuminate\Support\Facades\DB;
use PKP\plugins\BlockPlugin;

class SanguMostViewedBlockPlugin extends BlockPlugin
{
    /** @var SanguMostViewedPlugin Parent plugin */
    protected $_parentPlugin;

    /**
     * Constructor
     *
     * @param SanguMostViewedPlugin $parentPlugin
     */
    public function __construct($parentPlugin)
    {
        $this->_parentPlugin = $parentPlugin;
        parent::__construct();
    }

    /**
     * Get the parent plugin.
     *
     * @return SanguMostViewedPlugin
     */
    public function getParentPlugin()
    {
        return $this->_parentPlugin;
    }

    /**
     * @copydoc Plugin::getName()
     */
    public function getName()
    {
        return 'sanguMostViewedBlock';
    }

    /**
     * @copydoc Plugin::getPluginPath()
     */
    public function getPluginPath()
    {
        return $this->getParentPlugin()->getPluginPath();
    }

    /**
     * @copydoc Plugin::getTemplatePath()
     */
    public function getTemplatePath($inCore = false)
    {
        return $this->getParentPlugin()->getTemplatePath($inCore);
    }

    /**
     * @copydoc Plugin::getDisplayName()
     */
    public function getDisplayName()
    {
        return __('plugins.block.sanguMostViewed.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    public function getDescription()
    {
        return __('plugins.block.sanguMostViewed.description');
    }

    /**
     * @copydoc Plugin::getHideManagement()
     */
    public function getHideManagement()
    {
        return true;
    }

    /**
     * @copydoc LazyLoadPlugin::getEnabled()
     *
     * @param null|mixed $contextId
     */
    public function getEnabled($contextId = null)
    {
        if (!Application::isInstalled()) {
            return true;
        }
        return parent::getEnabled($contextId);
    }

    /**
     * Get the date start filter based on the time period setting.
     *
     * @param string $timePeriod
     * @return string|null
     */
    protected function getDateStart($timePeriod)
    {
        switch ($timePeriod) {
            case 'last7days':
                return date('Y-m-d', strtotime('-7 days'));
            case 'last30days':
                return date('Y-m-d', strtotime('-30 days'));
            case 'last1year':
                return date('Y-m-d', strtotime('-1 year'));
            case 'lifetime':
            default:
                return null;
        }
    }

    /**
     * @copydoc BlockPlugin::getContents()
     *
     * @param null|mixed $request
     */
    public function getContents($templateMgr, $request = null)
    {
        $context = $request->getContext();
        if (!$context) {
            return '';
        }

        $contextId = $context->getId();
        $parentPlugin = $this->getParentPlugin();

        // Get settings
        $timePeriod = $parentPlugin->getSetting($contextId, 'timePeriod') ?: 'lifetime';
        $articleCount = (int) ($parentPlugin->getSetting($contextId, 'articleCount') ?: 5);

        // Build query
        $query = DB::table('metrics_submission')
            ->select('submission_id', DB::raw('SUM(metric) as total_views'))
            ->where('context_id', $contextId)
            ->where('assoc_type', Application::ASSOC_TYPE_SUBMISSION)
            ->groupBy('submission_id')
            ->orderByDesc('total_views');

        // Apply date filter
        $dateStart = $this->getDateStart($timePeriod);
        if ($dateStart) {
            $query->where('date', '>=', $dateStart);
        }

        // We fetch more than needed in case some submissions are not published
        $metricsData = $query->limit($articleCount + 10)->get();

        $articles = [];
        foreach ($metricsData as $row) {
            if (count($articles) >= $articleCount) {
                break;
            }

            $submission = Repo::submission()->get($row->submission_id);
            if (!$submission || $submission->getData('status') !== Submission::STATUS_PUBLISHED) {
                continue;
            }

            $publication = $submission->getCurrentPublication();
            if (!$publication) {
                continue;
            }

            $title = $publication->getLocalizedTitle();
            $url = $request->getDispatcher()->url(
                $request,
                Application::ROUTE_PAGE,
                null,
                'article',
                'view',
                $submission->getBestId()
            );

            $articles[] = [
                'title' => $title,
                'url' => $url,
                'views' => (int) $row->total_views,
            ];
        }

        if (empty($articles)) {
            return '';
        }

        // Determine the subtitle label for the time period
        $timePeriodLabels = [
            'last7days' => __('plugins.generic.sanguMostViewed.settings.timePeriod.last7days'),
            'last30days' => __('plugins.generic.sanguMostViewed.settings.timePeriod.last30days'),
            'last1year' => __('plugins.generic.sanguMostViewed.settings.timePeriod.last1year'),
            'lifetime' => __('plugins.generic.sanguMostViewed.settings.timePeriod.lifetime'),
        ];

        $templateMgr->assign([
            'articles' => $articles,
            'blockTitle' => __('plugins.block.sanguMostViewed.title'),
            'timePeriodLabel' => $timePeriodLabels[$timePeriod] ?? '',
        ]);

        return parent::getContents($templateMgr, $request);
    }
}

if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\generic\sanguMostViewed\SanguMostViewedBlockPlugin', '\SanguMostViewedBlockPlugin');
}
