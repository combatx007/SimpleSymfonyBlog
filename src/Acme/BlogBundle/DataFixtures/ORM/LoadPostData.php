<?php
namespace Acme\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Acme\BlogBundle\Entity\Post;

class LoadPostData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $postOne = new Post();
        $postOne->setTitle('Simple-blog - учебный проект на симфони');
        $postOne->setUser('admin');
        $postOne->setPost('Symfony Live Portland 2013: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 2013!');
        $postOne->setCreated(new \DateTime());
        $postOne->setUpdated(new \DateTime());
        $manager->persist($postOne);
        $manager->flush();

        $postToo = new Post();
        $postToo->setTitle('A week of symfony');
        $postToo->setUser('admin');
        $postToo->setPost('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $postToo->setCreated(new \DateTime());
        $postToo->setUpdated(new \DateTime());
        $manager->persist($postToo);
        $manager->flush();

        $postThree = new Post();
        $postThree->setTitle('Sharing Objects between Fixtures');
        $postThree->setUser('admin');
        $postThree->setPost('Writing a basic fixture is simple. But what if you have multiple fixture classes and want to be able to refer to the data loaded in other fixture classes? For example, what if you load a User object in one fixture, and then want to refer to reference it in a different fixture in order to assign that user to a particular group?
The Doctrine fixtures library handles this easily by allowing you to specify the order in which fixtures are loaded.');
        $postThree->setCreated(new \DateTime());
        $postThree->setUpdated(new \DateTime());
        $manager->persist($postThree);
        $manager->flush();

        $postFour = new Post();
        $postFour->setTitle('Simple-blog - учебный проект на симфони');
        $postFour->setUser('admin');
        $postFour->setPost('Symfony Live Portland 2013: The Schedule has finally been published!
The schedule for the Symfony Live conference in Portland has just been published! Have a look at the great schedule and register now to the Symfony Live Portland 2013!');
        $postFour->setCreated(new \DateTime());
        $postFour->setUpdated(new \DateTime());
        $manager->persist($postFour);
        $manager->flush();

        $postFive = new Post();
        $postFive->setTitle('A week of symfony');
        $postFive->setUser('admin');
        $postFive->setPost('This week, the Symfony project introduced Debug to its growing family of components. In addition, a code sprint for Symfony 2.3 took place to boost the development of the upcoming first LTS version of Symfony2.');
        $postFive->setCreated(new \DateTime());
        $postFive->setUpdated(new \DateTime());
        $manager->persist($postFive);
        $manager->flush();
    }
}