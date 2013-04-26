<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\BlogBundle\Entity\Post;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(u.id) FROM Acme\BlogBundle\Entity\Post u');
        $count = $query->getSingleScalarResult();
        $limit = 3;
        $count_pages = ceil($count / $limit);
        $posts = $this->getDoctrine()->getRepository('AcmeBlogBundle:Post');
        $posts = $posts->findBy(array(),array('updated'=>'DESC'),3,0);
        return $this->render('AcmeBlogBundle:Default:index.html.twig',array('posts' => $posts, 'id' => '1', 'pages' => '$count_pages'));
    }

    public function pageAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $query = $em->createQuery('SELECT COUNT(u.id) FROM Acme\BlogBundle\Entity\Post u');
        $count = $query->getSingleScalarResult();
        $limit = 3;
        $count_pages = ceil($count / $limit);
        $offset = ($id - 1) * $limit;
        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(array(), array('updated'=>'DESC'), $limit, $offset);
        return $this->render('AcmeBlogBundle:Default:page.html.twig', array('posts' => $posts,'pages' => $count_pages,
        'id' => $id));
    }
}
