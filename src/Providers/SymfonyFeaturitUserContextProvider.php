<?php

namespace Featurit\Client\Symfony\Providers;

use Featurit\Client\Modules\Segmentation\DefaultFeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContext;
use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SymfonyFeaturitUserContextProvider implements FeaturitUserContextProvider
{
    public function __construct(
        private readonly RequestStack $requestStack,
        private readonly TokenStorageInterface $tokenStorage
    )
    {
    }

    public function getUserContext(): FeaturitUserContext
    {
        $userId = null;
        $token = $this->tokenStorage->getToken();
        if (!is_null($token)) {
            $userId = $this->tokenStorage->getToken()->getUserIdentifier();
        }
        $sessionId = $this->requestStack->getSession()->getId();
        $ipAddress = $this->requestStack->getCurrentRequest()->getClientIp();

        return new DefaultFeaturitUserContext(
            $userId,
            $sessionId,
            $ipAddress
        );
    }
}