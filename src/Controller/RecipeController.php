<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Json;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recettes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository): Response
    {
      
    $recipes= $repository->findWithDurationLowerThan(20);
        return $this ->render('recipe/index.html.twig',['recipes'=>$recipes]);
    }




    #[Route('/recettes/{slug}-{id}', name: 'recipe.show', requirements:['id'=>'\d+','slug'=>'[a-z0-9-]+'])]
    public function show(Request $request, string $slug , int $id, RecipeRepository $repository): Response
    {
        $recipe = $repository->find($id);
        if (!$recipe ) {
throw $this->createNotFoundException('La recette demandé n\'existe pas')   ;
        }
if($recipe->getSlug()!==$slug ){

    return $this->redirectToRoute('recipe.show',[
        'slug'=> $slug,
        'id'=>(int) $recipe->getId(),
]);


   
}

        return $this->render('recipe/show.html.twig',[
           'recipe' =>$recipe
        ]);
    }
    #[Route('/recettes/{id}/edit',name:'recipe.edit')]
    public function edit(Recipe $recipe,Request $request, EntityManagerInterface $em){
        $form=$this->createForm(RecipeType::class, $recipe);
        $form->handleRequest($request);
      if( $form->isSubmitted() && $form->isValid() ){
    $recipe->setUpdatedAt(new \DateTimeImmutable());
            $em->flush();
            $this->addFlash('success','La recette a bien été modifiée');
            return $this->redirectToRoute('recipe.index');}
                    return $this->render('recipe/edit.html.twig',[
                        'recipe' =>$recipe,
                        'form' =>$form
        ]);
    }
    #[Route('/recettes/create', name:'recipe.create')]
    public function Create(Request $request, EntityManagerInterface $em){
        $recipe =new Recipe();
$form =$this->createForm(RecipeType::class, $recipe);
$form->handleRequest($request);
if( $form->isSubmitted() && $form->isValid() ){
    $recipe->setCreatedAt(new \DateTimeImmutable());
    $recipe->setUpdatedAt(new \DateTimeImmutable());
    $em->persist($recipe);
        $em->flush();
        $this->addFlash('success','La recette a bien été créée');
        return $this->redirectToRoute('recipe.index') ;
    }
    return $this->render('recipe/create.html.twig',[
        'form' =>$form]) ;

}
}