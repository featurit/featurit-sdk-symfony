<?php

namespace Featurit\Client\Symfony\Factories;

use Featurit\Client\Featurit;
use Featurit\Client\FeaturitBuilder;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Featurit\Client\Symfony\Providers\EmptyFeaturitUserContextProvider;

class FeaturitFactory
{
    /**
     * @throws \Exception
     */
    public static function createFeaturit(
        string $tenantIdentifier = "",
        string $environmentKey = "",
        bool $enableAnalytics = false,
        bool $enableTracking = false,
        int $cacheTtlMinutes = 5,
        int $sendAnalyticsIntervalMinutes = 1,
        FeaturitUserContextProvider $featuritUserContextProvider = null
    ): Featurit
    {
        if (is_null($featuritUserContextProvider)) {
            $featuritUserContextProvider = new EmptyFeaturitUserContextProvider();
        }

        return (new FeaturitBuilder())
            ->setTenantIdentifier($tenantIdentifier)
            ->setApiKey($environmentKey)
            ->setIsAnalyticsModuleEnabled($enableAnalytics)
            ->setIsTrackingModuleEnabled($enableTracking)
            ->setSendAnalyticsIntervalMinutes($sendAnalyticsIntervalMinutes)
            ->setCacheTtlMinutes($cacheTtlMinutes)
            ->setFeaturitUserContextProvider($featuritUserContextProvider)
            ->build();
    }
}