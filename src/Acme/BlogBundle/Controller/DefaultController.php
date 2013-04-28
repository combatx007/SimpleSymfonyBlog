<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acme\BlogBundle\Form\Type\PostFormType;

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

        return $this->render('AcmeBlogBundle:Default:page.html.twig', [
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

    public function postAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AcmeBlogBundle:Post')->findOneBy(
            ['id'=>$id]
        );

        return $this->render('AcmeBlogBundle:Default:post.html.twig', [
            'post' => $post,
            'id' => $id
        ]);
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('AcmeBlogBundle:Post')->findOneBy(
            ['id'=>$id]
        );

        $task = new Post();
        $task->setTitle($post->getTitle());
        $task->setUser($post->getUser());
        $task->setPost($post->getPost());
        $task->setUpdated(new \DateTime('today'));
        $task->setCreated(new \DateTime('today'));

        $form = $this->createForm(new PostFormType(), $post);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->setFlash('id', $id);
                return $this->redirect($this->generateUrl('acme_blog_post', [$id]));
            }
        }


        return $this->render('AcmeBlogBundle:Default:post_edit.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
        ]);
    }

    public function successAction($id)
    {
        return $this->render('AcmeBlogBundle:Default:succes.html.twig');
    }
}
