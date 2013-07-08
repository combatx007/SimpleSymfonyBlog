<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\BlogBundle\Entity\Post;
use Acme\BlogBundle\Entity\Tag;
use Acme\BlogBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acme\BlogBundle\Form\Type\PostFormType;
use Acme\BlogBundle\Form\Type\TagFormType;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Acme\BlogBundle\Form\Type\CommentFormType;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = 3;
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            0
        );

        return $this->render('AcmeBlogBundle:Default:index.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => '1'
        ]);
    }

    public function pageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = 3;
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $offset = ($id - 1) * $limit;

        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            $offset
        );

        return $this->render('AcmeBlogBundle:Default:page.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => $id
        ]);
    }

    public function postAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->find('AcmeBlogBundle:Post', $id);

        $comment = new Comment();
        $form = $this->createForm(new CommentFormType(), $comment);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();

                return $this->redirect($this->generateUrl(
                    'acme_blog_homepage'
                ));
            }
        }

        return $this->render('AcmeBlogBundle:Default:post.html.twig', [
            'post' => $post,
            'id' => $id,
            'form' => $form->createView(),
        ]);
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->find('AcmeBlogBundle:Post', $id);
        $tags = $em->getRepository('AcmeBlogBundle:Tag')->findBy(
            [],
            ['id' => 'ASC'],
            100,
            0
        );

        $form = $this->createForm(new PostFormType(), $post);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();

                return $this->redirect($this->generateUrl(
                    'acme_blog_post',
                    ['id' => $id]
                ));
            }
        }


        return $this->render('AcmeBlogBundle:Default:post_edit.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = new Post();
        $post->setUser($this->get('security.context')->getToken()->getUser());

        $form = $this->createForm(new PostFormType(), $post);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();

                return $this->redirect($this->generateUrl(
                    'acme_blog_homepage'
                ));
            }
        }


        return $this->render('AcmeBlogBundle:Default:post_add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = 10;
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            0
        );

        return $this->render('AcmeBlogBundle:Default:admin.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => '1'
        ]);
    }

    public function adminpageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = 10;
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $offset = ($id - 1) * $limit;

        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            $offset
        );

        return $this->render('AcmeBlogBundle:Default:admin.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => $id
        ]);
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AcmeBlogBundle:Post')->findOneBy(
            ['id'=>$id]
        );

        $em->remove($post);
        $em->flush();

        return $this->render('AcmeBlogBundle:Default:post_delete.html.twig');
    }

    public function tagAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = new Tag();
        $tags = $em->getRepository('AcmeBlogBundle:Tag')->findBy(
            [],
            ['id' => 'ASC'],
            100,
            0
        );
        $form = $this->createForm(new TagFormType(), $tag);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();

                return $this->redirect($this->generateUrl(
                    'acme_blog_post_tag'
                ));
            }
        }

        return $this->render('AcmeBlogBundle:Default:post_tag.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags,
        ]);
    }

    public function tagsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->find('AcmeBlogBundle:Tag', $id);

        return $this->render('AcmeBlogBundle:Default:tag_posts.html.twig', [
            'tag' => $tag,
        ]);
    }
}
