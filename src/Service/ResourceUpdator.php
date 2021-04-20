<?php

declare(strict_types=1);

namespace App\Services;

use App\Authorizations\AuthentificationCheckerInterface;
use App\Authorizations\ResourceAccessCheckerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ResourceUpdator implements ResourceUpdatorInterface
{
    protected $methodAllowed = [
        Request::METHOD_PUT,
        Request::METHOD_PATCH,
        Request::METHOD_DELETE,
    ];

    /** @var ResourceAccessCheckerInterface */
    private $resourceAccessChecker;
    /** @var AuthentificationCheckerInterface */
    private  $authentificationChecker;

    public function __construct(
        ResourceAccessCheckerInterface $resourceAccessChecker,
        AuthentificationCheckerInterface $authentificationChecker
    ) {
        $this->resourceAccessChecker = $resourceAccessChecker;
        $this->authentificationChecker = $authentificationChecker;
    }

    public function process($method, User $user): bool
    {
        if (in_array($method, $this->methodAllowed, true)) {
            $this->authentificationChecker->isAuthenticated();
            $this->resourceAccessChecker->canAccess($user->getId());

            return true;
        }

        return false;
    }
}
