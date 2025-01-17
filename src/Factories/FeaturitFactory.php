<?php

namespace Featurit\Client\Symfony\Factories;

use Featurit\Client\Featurit;
use Featurit\Client\FeaturitBuilder;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Featurit\Client\Symfony\Providers\EmptyFeaturitUserContextProvider;
use Psr\SimpleCache\CacheInterface;

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
        FeaturitUserContextProvider $featuritUserContextProvider = null,
        CacheInterface $cache = null,
    ): Featurit
    {
        if (is_null($featuritUserContextProvider)) {
            $featuritUserContextProvider = new EmptyFeaturitUserContextProvider();
        }

        $builder = new FeaturitBuilder();

        $builder
            ->setTenantIdentifier($tenantIdentifier)
            ->setApiKey($environmentKey)
            ->setIsAnalyticsModuleEnabled($enableAnalytics)
            ->setIsTrackingModuleEnabled($enableTracking)
            ->setSendAnalyticsIntervalMinutes($sendAnalyticsIntervalMinutes)
            ->setCacheTtlMinutes($cacheTtlMinutes)
            ->setFeaturitUserContextProvider($featuritUserContextProvider);

        if (!is_null($cache)) {
            $builder->setCache($cache);
        }

        return $builder->build();
    }
}