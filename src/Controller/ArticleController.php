<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repo)
    {
        $articles = $repo->findBy(array(),array('id' => 'DESC'));

        return $this->render('index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Permet de créer un article
     * 
     * @Route("/article/new", name="article_create")
     * 
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $ad = new Article();
        $form = $this->createForm(ArticleType::class, $ad);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            //$manager = $this->getDoctrine()->getManager();

            $manager->persist($ad);
            $manager->flush();
            $this->addFlash(
                'success',"l'article {$ad->getLibelle()} a bien été créé"
            );
            return $this->redirectToRoute('article_show', [
                'id' => $ad->getId()
            ]);
        }

        return $this->render('article/form.html.twig', [
            'form' => $form->createView(),
            'create' => true,
            'edit' => false
        ]);
    }

    /**
     * Permet d'addicher une seule annonce
     *
     * @Route("/article/{id}", name="article_show")
     * 
     * @return Response
     */
    public function show($id, ArticleRepository $article)
    {
        $article = $article->findOneById($id);

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/list", name="list")
     */
    public function list(ArticleRepository $repo)
    {
        $articles = $repo->findBy(array(),array('id' => 'DESC'));

        return $this->render('article/liste.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * Permet d'editer un article
     *
     * @Route("/article/{id}/edit")
     * 
     * @return response
     */
    public function edit(Article $article, Request $request, ObjectManager $manager){
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($article);
            $manager->flush();
            $this->addFlash(
                'success',"l'article {$article->getLibelle()} a bien été modifié"
            );
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }
        return $this->render("article/form.html.twig",[
            'form'=>$form->createView(),
            'article' => $article,
            'edit' => true,
            'create' => false
            ]);
    }

    /**
     * Permet de supprimer
     *
     * @Route("/article/{id}/delete")
     * 
     * @return response
     */
    public function delete(Article $article, ObjectManager $manager)
    {
        $manager->remove($article);
        $manager->flush();
        $this->addFlash(
            'success',"l'article {$article->getLibelle()} a bien été supprimé"
        );
        return $this->redirect('/list');
    }
}
