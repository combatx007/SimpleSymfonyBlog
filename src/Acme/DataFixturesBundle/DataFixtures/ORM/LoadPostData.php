<?php
namespace Acme\DataFixturesBundle\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Acme\BlogBundle\Entity\Post;
use Acme\UserBundle\Entity\User;
use Acme\BlogBundle\Entity\Comment;
use FOS\UserBundle\Model\UserManager;

class LoadPostData extends ContainerAware implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $userAdmin->setPassword($encoder->encodePassword('123', $userAdmin->getSalt()));
        $userAdmin->setEmail('312@mail.ru');
        $userAdmin->setEmailCanonical('312@mail.ru');
        $userAdmin->setEnabled(true);
        $userAdmin->addRole('ROLE_SUPER_ADMIN');
        $manager->persist($userAdmin);

        $user = new User();
        $user->setUsername('user');
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($userAdmin);
        $user->setPassword($encoder->encodePassword('123', $user->getSalt()));
        $user->setEmail('3122@mail.ru');
        $user->setEmailCanonical('3122@mail.ru');
        $user->setEnabled(true);
        $user->addRole('ROLE_DEFAULT');
        $manager->persist($user);

        $manager->flush();
        
        $post = new Post();
        $post->setTitle('Simple-blog - учебный проект на симфони');
        $post->setUser($userAdmin);
        $post->setAnnotation('Symfony Live Portland 20Post 13: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 20Post 13!');
        $post->setPost('Symfony Live Portland 20Post 13: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 20Post 13!');
        $post->setDescription('Описание');
        $post->setKeyword('Ключ');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('A week of symfony');
        $post->setUser($userAdmin);
        $post->setAnnotation('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $post->setPost('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $post->setDescription('Описание');
        $post->setKeyword('Ключ');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('Sharing Objects between Fixtures');
        $post->setUser($userAdmin);
        $post->setAnnotation('Writing a basic fixture is simple. But what if you have multiple fixture classes and want to be able to refer to the data loaded in other fixture classes? For example, what if you load a User object in one fixture, and then want to refer to reference it in a different fixture in order to assign that user to a particular group?
        The Doctrine fixtures library handles this easily by allowing you to specify the order in which fixtures are loaded.');
        $post->setPost('Writing a basic fixture is simple. But what if you have multiple fixture classes and want to be able to refer to the data loaded in other fixture classes? For example, what if you load a User object in one fixture, and then want to refer to reference it in a different fixture in order to assign that user to a particular group?
The Doctrine fixtures library handles this easily by allowing you to specify the order in which fixtures are loaded.');
        $post->setDescription('Описание');
        $post->setKeyword('Ключ');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('Simple-blog - учебный проект на симфони');
        $post->setUser($userAdmin);
        $post->setAnnotation('Symfony Live Portland 20Post 13: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 20Post 13!');
        $post->setPost('Symfony Live Portland 20Post 13: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 20Post 13!');
        $post->setDescription('Описание');
        $post->setKeyword('Ключ');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('A week of symfony');
        $post->setUser($userAdmin);
        $post->setAnnotation('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $post->setPost('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $post->setDescription('Описание');
        $post->setKeyword('Ключ');
        $post->setCreated(new \DateTime());
        $post->setUpdated(new \DateTime());
        $manager->persist($post);

        $comment = new Comment();
        $comment->setComment('Коммент');
        $post = new Post();
        $comment->setUser($userAdmin);
        $comment->setPosts($post->getPost());
        $manager->persist($comment);

        $manager->flush();
    }
}
