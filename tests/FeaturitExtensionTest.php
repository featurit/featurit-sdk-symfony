<?php

namespace Featurit\Client\Symfony\Tests;

use Featurit\Client\Symfony\DependencyInjection\FeaturitExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

class FeaturitExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new FeaturitExtension(),
        ];
    }

    public function test_it_loads_the_tenant_identifier_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('tenant_identifier', '%env(FEATURIT_TENANT_IDENTIFIER)%');
    }

    public function test_it_loads_the_environment_key_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('environment_key', '%env(FEATURIT_ENVIRONMENT_KEY)%');
    }

    public function test_it_loads_the_enable_analytics_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('enable_analytics', '%env(bool:FEATURIT_ENABLE_ANALYTICS)%');
    }

    public function test_it_loads_the_enable_tracking_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('enable_tracking', '%env(bool:FEATURIT_ENABLE_TRACKING)%');
    }

    public function test_it_loads_the_cache_ttl_minutes_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('cache_ttl_minutes', '%env(int:FEATURIT_CACHE_TTL_MINUTES)%');
    }

    public function test_it_loads_the_send_analytics_interval_minutes_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('send_analytics_interval_minutes', '%env(int:FEATURIT_SEND_ANALYTICS_INTERVAL_MINUTES)%');
    }

    public function test_it_has_featurit_client_service(): void
    {
        $this->load();
        $this->assertContainerBuilderHasService('featurit.client');
    }

    public function test_it_has_featurit_user_context_provider_service(): void
    {
        $this->load();
        $this->assertContainerBuilderHasService('featurit.featurit_user_context_provider');
    }

    public function test_it_has_featurit_client_alias(): void
    {
        $this->load();
        $this->assertContainerBuilderHasAlias('Featurit\Client\Featurit');
    }

    public function test_it_has_cache(): void
    {
        $this->load([
            'cache' => '@my_custom_cache',
        ]);
        $this->assertContainerBuilderHasService('featurit.cache');
    }
}