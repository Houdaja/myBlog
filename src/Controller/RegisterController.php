<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{

    public function __construct(EntityManagerInterface $manager, UserPasswordHasherInterface $passwordHash){
        $this->manager = $manager;
        $this->passwordHash = $passwordHash;

    }

    /**
     * @Route("/register", name="app_register")
     */
    public function index(Request $request): Response
    {
        $user = new User();// Nouvelle instance de user
        $form = $this->createForm(RegisterType::class, $user);// Création du formulaire
        $form->handleRequest($request); //Traitement du formulaire
        if($form->isSubmitted() && $form->isValid()){// Si le formulaire est soumis et valide alors....
                //dd($form->getData());
                //dd équivaut au vardump

               $user->setPassword($this->passwordHash->hashPassword($user, $user->getPassword()));//hashage de mot de passe 

                $this->manager->persist($user);// on envoie en bdd
                $this->manager->flush();// on envoie en bdd

        }


        return $this->render('register/index.html.twig', [
            'myForm' => $form->createView() // On passe le formulaire à la vue
        ]);
    }
}
