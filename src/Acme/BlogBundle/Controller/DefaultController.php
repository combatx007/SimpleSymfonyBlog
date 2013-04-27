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
        $task->setCreated($post->getCreated());

        $form = $this->createForm(new PostFormType(), $post);

        if ($request->isMethod('POST')) {
            if ($request->request->has('post')) {
                $form->bind($request);
                if ($form->isValid()) {
                    $edit_form = $form->getData();
                    $em->persist($edit_form);
                    $em->flush();
                }
            }
        }

        return $this->render('AcmeBlogBundle:Default:post_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function successAction($id)
    {
        return $this->render('AcmeBlogBundle:Default:succes.html.twig');
    }
}
