<?php

namespace Featurit\Client\Symfony\Factories;

use Featurit\Client\Featurit;
use Featurit\Client\FeaturitBuilder;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Featurit\Client\Symfony\Providers\SymfonyFeaturitUserContextProvider;

class FeaturitFactory
{
    /**
     * @throws \Exception
     */
    public static function createFeaturit(
        string $tenantIdentifier = "",
        string $environmentKey = "",
        int $cacheTtlMinutes = 5,
        FeaturitUserContextProvider $featuritUserContextProvider = null
    ): Featurit
    {
        if (is_null($featuritUserContextProvider)) {
            $featuritUserContextProvider = new SymfonyFeaturitUserContextProvider();
        }

        return (new FeaturitBuilder())
            ->setTenantIdentifier($tenantIdentifier)
            ->setApiKey($environmentKey)
            ->setCacheTtlMinutes($cacheTtlMinutes)
            ->setFeaturitUserContextProvider($featuritUserContextProvider)
            ->build();
    }
}