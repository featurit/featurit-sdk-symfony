<?php

namespace Featurit\Client\Symfony\Providers;

use Featurit\Client\Modules\Segmentation\DefaultFeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;

class EmptyFeaturitUserContextProvider implements FeaturitUserContextProvider
{
    private FeaturitUserContext $featuritUserContext;

    public function __construct()
    {
        $this->featuritUserContext = new DefaultFeaturitUserContext(null, null, null);
    }

    public function getUserContext(): FeaturitUserContext
    {
        return $this->featuritUserContext;
    }
}