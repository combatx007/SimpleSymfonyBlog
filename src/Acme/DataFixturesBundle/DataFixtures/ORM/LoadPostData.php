<?php
namespace Acme\DataFixturesBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\BlogBundle\Entity\Post;
use Acme\UserBundle\Entity\User;

class LoadPostData implements FixtureInterface
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
        
        $post = new Post();
        $post->setTitle('Simple-blog - учебный проект на симфони');
        $post->setUser($user Admin);
        $post->setPost('Symfony Live Portland 20Post 13: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 20Post 13!');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('A week of symfony');
        $post->setUser($user Admin);
        $post->setPost('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('Sharing Objects between Fixtures');
        $post->setUser($user Admin);
        $post->setPost('Writing a basic fixture is simple. But what if you have multiple fixture classes and want to be able to refer to the data loaded in other fixture classes? For example, what if you load a User object in one fixture, and then want to refer to reference it in a different fixture in order to assign that user to a particular group?
The Doctrine fixtures library handles this easily by allowing you to specify the order in which fixtures are loaded.');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('Simple-blog - учебный проект на симфони');
        $post->setUser($user Admin);
        $post->setPost('Symfony Live Portland 20Post 13: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 20Post 13!');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('A week of symfony');
        $post->setUser($user Admin);
        $post->setPost('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $manager->flush();
    }
}
