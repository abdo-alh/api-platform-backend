<?php

declare(strict_types=1);

namespace App\Authorizations;

use App\Entity\User;
use App\Exceptions\ResourceAccessException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class ResourceAccessChecker implements ResourceAccessCheckerInterface
{
    /** @var ?User */
    private $user;

    public function __construct(Security $security)
    {
        $this->user = $security->getUser();
    }

    public function canAccess(?int $id): void
    {
        if ($this->user->getId() !== $id) {
            throw new ResourceAccessException(Response::HTTP_UNAUTHORIZED, self::MESSAGE_ERROR);
        }
    }
}
