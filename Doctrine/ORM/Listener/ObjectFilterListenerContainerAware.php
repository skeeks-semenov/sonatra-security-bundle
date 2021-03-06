<?php

/*
 * This file is part of the Sonatra package.
 *
 * (c) François Pluchino <francois.pluchino@sonatra.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonatra\Bundle\SecurityBundle\Doctrine\ORM\Listener;

use Sonatra\Component\Security\Doctrine\ORM\Listener\ObjectFilterListener;
use Sonatra\Component\Security\ObjectFilter\ObjectFilterInterface;
use Sonatra\Component\Security\Permission\PermissionManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * This class listens to all database activity and automatically adds constraints as permissions.
 *
 * @author François Pluchino <francois.pluchino@sonatra.com>
 */
class ObjectFilterListenerContainerAware extends ObjectFilterListener
{
    /**
     * @var ContainerInterface
     */
    public $container;

    /**
     * {@inheritdoc}
     */
    protected function init()
    {
        if (null !== $this->container) {
            /* @var TokenStorageInterface $tokenStorage */
            $tokenStorage = $this->container->get('security.token_storage');
            /* @var PermissionManagerInterface $permManager */
            $permManager = $this->container->get('sonatra_security.permission_manager');
            /* @var ObjectFilterInterface $objectFilter */
            $objectFilter = $this->container->get('sonatra_security.object_filter');

            $this->setTokenStorage($tokenStorage);
            $this->setPermissionManager($permManager);
            $this->setObjectFilter($objectFilter);
            $this->initialized = true;
            $this->container = null;
        }
    }
}
