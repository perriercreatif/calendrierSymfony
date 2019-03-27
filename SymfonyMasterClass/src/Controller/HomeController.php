<?php
// src/Controller/AdvertController.php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\User;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class HomeController extends AbstractController
{


    public function showHome()
    {
        return $this->render('front/home.html.twig');
    }

    public function showOnePost(Post $post = null){
        /*$post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);*/

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('front/showOnePost.html.twig',[
//            'postID' =>$id,
            'post' =>$post
        ]);
    }

    public function showAllPost(PostRepository $repo){
        $post = $repo->findAll();

        return $this->render('front/showAllPost.html.twig',[
            'post' =>$post
        ]);
    }

    public function form(Post $post = null, Request $request, ObjectManager $manager){
        if (!$post){
            $post = new Post();
        }

        $form = $this-> createForm(PostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $manager->persist($post);
            $manager->flush();
            return $this->redirectToRoute('blog', ['id' => $post->getId()]);
        }
        return $this->render('front/createPost.html.twig', [
            'formPost' => $form->createView(),
            'createPost' => $post->getId() !== null
        ]);
    }

    /*public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $post->setTitle('New post name!');
        $entityManager->flush();

        return $this->redirectToRoute('home', [
            'id' => $post->getId()
        ]);
    }*/

    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->redirectToRoute('home', [
            'id' => $post->getId()
        ]);
    }

    public function showDashBoard(){
        return $this->render('bo/dashboard.html.twig');
    }

    //géré par security
    public function logout(){
    }

    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // creates a task and gives it some dummy data for this example
        $user = new User();
        $user->setUsername('pseudo');
        $user->setPassword('password');

        $form = $this->createFormBuilder($user)
            ->add('_username', TextType::class)
            ->add('_password', PasswordType::class)
            ->add('save', SubmitType::class, ['label' => 'Se connecter'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            //return $this->redirectToRoute('bo');
        }

        return $this->render('front/logForm.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}