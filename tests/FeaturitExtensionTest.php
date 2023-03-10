<?php

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

    public function test_it_loads_the_cache_ttl_minutes_parameter_with_correct_default_value(): void
    {
        $this->load();
        $this->assertContainerBuilderHasParameter('cache_ttl_minutes', '%env(FEATURIT_CACHE_TTL_MINUTES)%');
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
}