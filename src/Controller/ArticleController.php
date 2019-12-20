<?php
namespace App\Controller;

use App\Entity\Article;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
/**
* @Route("/article", name="article_")
*/

class ArticleController extends AbstractController
{
  /**
  * @Route("/create", name="create")
  */
  public function create(Request $request)
  {
    $article = new Article;

    $form = $this->createFormBuilder($article)
    ->add('title', TextType::class, ['label' => "Titre"])
    ->add('content', TextareaType::class, ['label' => "Contenu"  ])
    ->add('image', TextType::class, ['required' => false])
    ->add('save', SubmitType::class, [
      'label' => 'Créer article',
      'attr' => [
        'class' => 'btn-success'
      ]
    ])
    ->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $dateTime = new \DateTime();
      $article->setDate($dateTime);
      $em = $this->getDoctrine()->getManager();
      $em->persist($article);
      $em->flush();
      dump($form);
    }

    return $this->render('article/create.html.twig', [
      'form' => $form->createView(),
    ]);


  }

  /**
  * @Route("/view/{id}", name="view")
  */
  public function show($id)
  {
    $article = new Article;
    $article = $this->getDoctrine()->getRepository(Article::class)->find($id);

    return $this->render('article/uniqueArticle.html.twig', [
      'article' => $article,
    ]);
  }



}
