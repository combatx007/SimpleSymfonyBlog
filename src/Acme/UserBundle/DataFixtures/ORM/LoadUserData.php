<?php
namespace Acme\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\UserBundle\Entity\User;

class LoadUserData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword('test');
        $userAdmin->setEmail('312@mail.ru');
        $userAdmin->setEmailCanonical('312@mail.ru');
        $userAdmin->addRole('ROLE_SUPER_ADMIN');
        $manager->persist($userAdmin);

        $user = new User();
        $user->setUsername('user');
        $user->setPassword('test');
        $user->setEmail('3122@mail.ru');
        $user->setEmailCanonical('3122@mail.ru');
        $user->addRole('ROLE_DEFAULT');
        $manager->persist($user);

        $manager->flush();
    }
}
