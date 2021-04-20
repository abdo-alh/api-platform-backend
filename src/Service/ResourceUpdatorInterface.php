<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

interface ResourceUpdatorInterface
{
    public function process(string $method, User $user): bool;
}
