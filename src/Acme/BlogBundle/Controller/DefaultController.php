<?php

namespace Acme\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Acme\BlogBundle\Entity\Post;
use Acme\BlogBundle\Entity\Tag;
use Acme\BlogBundle\Entity\Options;
use Acme\BlogBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Acme\BlogBundle\Form\Type\PostFormType;
use Acme\BlogBundle\Form\Type\TagFormType;
use Acme\BlogBundle\Form\Type\CommentFormType;
use Acme\BlogBundle\Form\Type\CommentadminFormType;
use Acme\BlogBundle\Form\Type\OptionFormType;

    class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = $this->get('options')->getOptions()->getCountpost();
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            0
        );

        $options = $this->get('options')->getOptions();
        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();



        return $this->render('AcmeBlogBundle:Default:index.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => '1',
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
            'options' => $options,
        ]);
    }

    public function pageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = $this->get('options')->getOptions()->getCountpost();
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $offset = ($id - 1) * $limit;

        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            $offset
        );

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:page.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => $id,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function postAction($id, $url, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var Post $post */
        $post = $em->find('AcmeBlogBundle:Post', $id);
        $user = $this->get('security.context')->getToken()->getUser();


        $comment = new Comment();
        $form = $this->createForm(new CommentFormType(), $comment);
        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {
                $post->addComment($form->getData());
                if ($this->get('security.context')->getToken()->getUser() !== 'anon.'){
                   $comment->setUser($this->get('security.context')->getToken()->getUser());
                }
                $comment->setPost($id);
                $em->flush();

                return $this->redirect($this->generateUrl('acme_blog_post', ['id' => $id, 'url' => $url]));
            }
        }

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:post.html.twig', [
            'post' => $post,
            'id' => $id,
            'url' => $url,
            'form' => $form->createView(),
            'user' => $user,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->find('AcmeBlogBundle:Post', $id);


        $form = $this->createForm(new PostFormType(), $post);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
                $url = $this->get('translit')->fromUkrainianToEnglish($post->getTitle());
                $post->setUrl($url);
                $this->get('tagcloud')->check();
                $em->flush();


                return $this->redirect($this->generateUrl(
                    'acme_blog_post',
                    ['id' => $id, 'url' => $form->getData()->getUrl()]
                ));
            }
        }

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:post_edit.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
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
                $url = $this->get('translit')->fromUkrainianToEnglish($form->getData()->getTitle());
                $post->setUrl($url);
                $em->flush();
                $this->get('tagcloud')->check();

                return $this->redirect($this->generateUrl(
                    'acme_blog_homepage'
                ));
            }
        }

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:post_add.html.twig', [
            'form' => $form->createView(),
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = $this->get('options')->getOptions()->getCountadmin();
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $posts = $em->getRepository('AcmeBlogBundle:Post')->findBy(
            [],
            ['updated' => 'DESC'],
            $limit,
            0
        );

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:admin.html.twig', [
            'posts' => $posts,
            'pages' => $count_pages,
            'id' => '1',
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function adminpageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Post p');

        $limit = $this->get('options')->getOptions()->getCountadmin();
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
            'id' => $id,
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
        $this->get('tagcloud')->check();

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

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:post_tag.html.twig', [
            'form' => $form->createView(),
            'tags' => $tags,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function tagsAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->find('AcmeBlogBundle:Tag', $id);
        $limit = $this->get('options')->getOptions()->getCountpost();
        $dql = "SELECT u, a FROM AcmeBlogBundle:Post u JOIN u.tags a WHERE a.id = $id";
        $query = $em->createQuery($dql)
            ->setFirstResult(0)
            ->setMaxResults($limit);

        $post = $query->getResult();

        $dql = "SELECT COUNT(a.id) FROM AcmeBlogBundle:Post u JOIN u.tags a WHERE a.id = $id";
        $query = $em->createQuery($dql);
        $count = ceil($query->getSingleScalarResult() / $limit);
        $idp = 1;

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:tag_posts.html.twig', [
            'tag' => $tag,
            'post' => $post,
            'count' => $count,
            'id' => $id,
            'idp' => $idp,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function tagspageAction($id, $idp)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->find('AcmeBlogBundle:Tag', $id);
        $limit = $this->get('options')->getOptions()->getCountpost();
        $offset = ($idp - 1) * $limit;
        $dql = "SELECT u, a FROM AcmeBlogBundle:Post u JOIN u.tags a WHERE a.id = $id";
        $query = $em->createQuery($dql)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $post = $query->getResult();

        $dql = "SELECT COUNT(a.id) FROM AcmeBlogBundle:Post u JOIN u.tags a WHERE a.id = $id";
        $query = $em->createQuery($dql);
        $count = ceil($query->getSingleScalarResult() / $limit);

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:tag_posts_page.html.twig', [
            'tag' => $tag,
            'post' => $post,
            'count' => $count,
            'id' => $id,
            'idp' => $idp,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function tagcollectionAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT COUNT(a.id) FROM AcmeBlogBundle:Post u JOIN u.tags a";
        $query = $em->createQuery($dql);

        $count = $query->getResult();


        return $this->render('AcmeBlogBundle:Default:tag_posts_page.html.twig', [
            'counti' => $count,
        ]);
    }

    public function commentAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->find('AcmeBlogBundle:Comment', $id);


        $form = $this->createForm(new CommentadminFormType(), $comment);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();


                return $this->redirect($this->generateUrl(
                    'acme_blog_view_comment',
                    ['id' => $id]
                ));
            }
        }

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:comment_edit.html.twig', [
            'form' => $form->createView(),
            'id' => $id,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function commentviewAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->find('AcmeBlogBundle:Comment', $id);

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:comment.html.twig', [
            'comment' => $comment,
            'id' => $id,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);
    }

    public function commentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Comment p');

        $limit = $this->get('options')->getOptions()->getCountadmin();
        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $comments = $em->getRepository('AcmeBlogBundle:Comment')->findBy(
            [],
            ['created' => 'DESC'],
            $limit,
            0
        );

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:comment_admin.html.twig', [
            'comments' => $comments,
            'count' => $count_pages,
            'id' => '1',
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);

    }

    public function commentspageAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT COUNT(p.id) FROM AcmeBlogBundle:Comment p');

        $limit = $this->get('options')->getOptions()->getCountadmin();
        $offset = ($id - 1) * $limit;

        $count_pages = ceil($query->getSingleScalarResult() / $limit);
        $comments = $em->getRepository('AcmeBlogBundle:Comment')->findBy(
            [],
            ['created' => 'DESC'],
            $limit,
            $offset
        );

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:comment_admin_page.html.twig', [
            'comments' => $comments,
            'id' => $id,
            'count' => $count_pages,
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
        ]);

    }

    public function optionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dql = "SELECT u.id FROM AcmeBlogBundle:Options u";
        $query = $em->createQuery($dql);

        $id = $query->getResult();
        $id = $id['0']['id'];


        $option = $em->find('AcmeBlogBundle:Options', $id);

        $form = $this->createForm(new OptionFormType(), $option);
        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();

                return $this->redirect($this->generateUrl(
                    'acme_blog_admin_option'
                ));
            }
        }

        $tagcloudcall = $this->get('tagcloudcall')->check();
        $mean = $this->get('tagcloud')->mean();

        return $this->render('AcmeBlogBundle:Default:option.html.twig', [
            'tagcloudcall' => $tagcloudcall,
            'mean' => $mean,
            'form' => $form->createView(),
            'option' => $option,
            'id' => $id,
        ]);
    }

}
