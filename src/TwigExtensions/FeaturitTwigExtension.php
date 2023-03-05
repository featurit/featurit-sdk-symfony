<?php

namespace Featurit\Client\Symfony\TwigExtensions;

use Featurit\Client\Featurit;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FeaturitTwigExtension extends AbstractExtension
{
    private Featurit $featurit;

    public function __construct(Featurit $featurit)
    {
        $this->featurit = $featurit;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('feature_is_active', [$this, 'featureIsActive']),
            new TwigFunction('feature_version_equals', [$this, 'featureVersionEquals']),
        ];
    }

    public function featureIsActive(string $featureName): bool
    {
        return $this->featurit->isActive($featureName);
    }

    public function featureVersionEquals(string $featureName, string $value): bool
    {
        return $this->featurit->version($featureName) == $value;
    }
}