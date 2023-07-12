# FeaturIT SDK for Symfony

Symfony wrapper of the PHP client for the FeaturIT Feature Flag management platform.

## Description

This package aims to simplify the integration of the FeaturIT API in a Symfony project.

## Getting started

### Dependencies

* PHP >= 8.0.2
* symfony/framework-bundle >= 5.2
* psr/http-client-implementation
* psr/simple-cache-implementation

### Installing

`composer require featurit/featurit-sdk-symfony -W`

If there's no package providing psr/http-client-implementation,
visit https://packagist.org/providers/psr/http-client-implementation and choose the package
that better suits your project.

If there's no package providing psr/simple-cache-implementation,
visit https://packagist.org/providers/psr/simple-cache-implementation and choose the package
that better suits your project.

Inside your config/bundles.php file, add:

```
    Featurit\Client\Symfony\FeaturitBundle::class => ['all' => true],
```

If you want to create your own configuration file in order to customize things
like the default FeaturitUserContextProvider, create a file in `config/packages/featurit.yaml` 
with the following contents:

```
featurit:
    tenant_identifier: '%env(FEATURIT_TENANT_IDENTIFIER)%'
    environment_key: '%env(FEATURIT_ENVIRONMENT_KEY)%'
    enable_analytics: '%env(FEATURIT_ENABLE_ANALYTICS)%'
    cache_ttl_minutes: '%env(FEATURIT_CACHE_TTL_MINUTES)%'
    send_analytics_interval_minutes: '%env(FEATURIT_SEND_ANALYTICS_INTERVAL_MINUTES)%'
    featurit_user_context_provider: '@my_service_implementing_featurit_user_context_provider'
```

### Basic Usage

That's how you would use Featurit in one of your controllers, services, or anywhere inside
your PHP codebase:

```
your_method(Featurit $featurit)
{
    if ($featurit->isActive('YOUR_FEATURE_NAME')) {
        your_feature_code();
    }
}
```

Or in order to check which is the version of your feature:

```
your_method(Featurit $featurit)
{
    if ($featurit->version('YOUR_FEATURE_NAME') == 'v1') {
        your_feature_code_for_v1();
    } else if ($featurit->version('YOUR_FEATURE_NAME') == 'v2') {
        your_feature_code_for_v2();
    }
}
```

### Twig extension

For convenience we provide 2 twig functions which allow to render html depending on the Feature Flag values.

Inside your twig template, you can use them like this:

```
<div>
    <h2>This code will always be visible</h2>

    {% if feature_is_active('MY_ACTIVE_FEATURE') %}
        <h2>Welcome to MY_ACTIVE_FEATURE!</h2>
    {% endif %}

    {% if feature_version_equals('FEATURE_WITH_VERSIONS', 'v1') %}
        <h2>Welcome to v1!</h2>
    {% elseif feature_version_equals('FEATURE_WITH_VERSIONS', 'v2') %}
        <h2>Welcome to v2!</h2>
    {% endif %}
</div>
```

### Defining your FeaturitUserContext

In order to show different versions of a feature to different users,
Featurit needs to know about the attributes your user has in a certain context.

You can define the context using the as follows:

```
your_method(Featurit $featurit)
{
    $contextData = get_your_user_context_data();

    $featurit->setUserContext(
        new DefaultFeaturitUserContext(
            $contextData['userId'],
            $contextData['sessionId'],
            $contextData['ipAddress'],
            [
                'role' => $contextData['role'],
                ...
            ]
        )
    );
}
```

### Defining a custom FeaturitUserContextProvider

This is an alternative to using `$featurit->setUserContext(...);`.

By default, Featurit SDK for Symfony comes with a default FeaturitUserContextProvider
adapted for Symfony, but if you want to create your own, create a service un your `services.yaml` file as follows:

```
services:
...
    Namespace\For\MyFeaturitUserContextProvider
        arguments:
            - arg1
            - arg2
            - ...
```

And then add it to the `featurit.yaml` config file as:

```
featurit:
    ...
    featurit_user_context_provider: '@Namespace\For\MyFeaturitUserContextProvider'
```

Let's say that your platform users have a "role" attribute that you use to decide which features
you show to each user. In that case you could create an implementation like:

```
<?php

namespace My\Namespace\Of\Choice;

use Featurit\Client\Modules\Segmentation\DefaultFeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;

class MyCustomFeaturitUserContextProvider implements FeaturitUserContextProvider
{
    public function getUserContext(): FeaturitUserContext
    {
        $userId = my_logic_to_get_the_user_identifier();
        $sessionId = my_logic_to_get_the_session_id();
        $ipAddress = my_logic_to_get_the_ip_address();
        
        $role = my_logic_to_get_the_user_role();

        return new DefaultFeaturitUserContext(
            $userId,
            $sessionId,
            $ipAddress,
            [
                'role' => $role,
            ]
        );
    }
}
```

Then you must replace your implementation in the `featurit.yaml` file as explained before.

And that should do it, from now on your segmentation rules will use the role attribute.

### Authors

FeaturIT

https://www.featurit.com

featurit.tech@gmail.com