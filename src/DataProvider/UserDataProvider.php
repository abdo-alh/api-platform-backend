<?php

namespace App\DataProvider;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\Exception\RuntimeException;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\DenormalizedIdentifiersAwareItemDataProviderInterface;

class UserDataProvider implements ContextAwareCollectionDataProviderInterface, DenormalizedIdentifiersAwareItemDataProviderInterface, RestrictedDataProviderInterface
{

    private $userRepository;
    private $collectionDataProvider;
    private $security;
    private $itemDataProvider;

    public function __construct(Security $security, UserRepository $userRepository,CollectionDataProviderInterface $collectionDataProvider, ItemDataProviderInterface $itemDataProvider)
    {
        $this->userRepository = $userRepository;
        $this->collectionDataProvider = $collectionDataProvider;
        $this->security = $security;
        $this->itemDataProvider = $itemDataProvider;
    }

    public function supports(string $resourceClass, ?string $operationName = null, array $context = []): bool
    {
        return $resourceClass === User::class;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        /** @var User[] $users */
        $users = $this->collectionDataProvider->getCollection($resourceClass, $operationName, $context);
        $currentUser = $this->security->getUser();
        foreach ($users as $user) {
            $user->setStatus($currentUser === $user);
        }
        return $users;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        /*if (is_array($id)) {
            throw new RuntimeException('id as array not expected');
        }

        $user = $this->userRepository->findPartial((int) $id);
        return $user;
        return $this->userRepository->find($id);*/
        
        /** @var User|null $item */
        $item = $this->itemDataProvider->getItem($resourceClass, $id, $operationName, $context);
        if (!$item) {
            return null;
        }
        $item->setStatus($this->security->getUser() === $item);
        return $item;
    }
}