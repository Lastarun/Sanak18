<?php

namespace AppBundle\Controller;

use AppBundle\Entity\News;
use AppBundle\Entity\Comment;
use AppBundle\Form\CommentType;
use AppBundle\Form\NewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;


class NewsController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('news/index.html.twig', [
            'user' => null,
            'news' => null
        ]);
    }

    /**
     * @Route("/news", name="feed")
     */
    public function feedAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('news/news.html.twig', [
            'user' => null,
            'news' => null
        ]);
    }

    /**
     * @Route("/news/{id}",name="show_news", requirements={"id"="\d+"})
     * @param integer $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $user = $this->getUser();
        $repo = $this->getDoctrine()->getRepository(News::class);
        $commentsRepo = $this->getDoctrine()->getRepository(Comment::class);

        $news = $repo->find($id);
        $comment = $commentsRepo->findByNewsId($id);
        return $this->render('News/news.html.twig', array(
            'user'=> $user,
            'news' => $news,
            'comments' => $comment
        ));

    }


    /**
     * @param Request $request
     * @Route("/news/new", name="create_news")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/news/new", name="create")
     */
    public function createAction(Request $request)
    {
        $news = new News();

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $news = $form->getData();
            $news->setDate(time());
            $news->setStatus(true);
            $news->setAutor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($news);
            $entityManager->flush();

            return $this->redirectToRoute('show_news', array('id' => 1));
        }

        return $this->render('news/create_news.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    /**
     * @param Request $request
     * @Route("/news/{id}/comment", name="create_comment",  requirements={"id"="\d+"})
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @param integer $id
     */

    public function createCommentAction(Request $request, $id)
    {
        $comment= new Comment();

        $form = $this->createForm( CommentType::class, $comment );

        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $comment = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager ->persist($comment);
            $entityManager -> flush();

        }

        return $this-> redirectToRoute('show_news', array('id'=>1));
    }
}
