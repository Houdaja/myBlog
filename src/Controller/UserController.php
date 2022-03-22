<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{

    public function __construct(EntityManagerInterface $manager)
    
    {
        $this->manager = $manager;
    }
    /**
     * @Route("/user", name="app_user")
     */
    public function index(Request $request): Response
    {

        $users = new User();
        $users= $this->manager->getRepository(User::class)->findAll(); 
        return $this->render('user/index.html.twig', [
            'users' => $users,
            
        ]);

        }


        /**
     * @Route("/user/delete/{id}", name="app_user_delete")
     */
    public function userDelete(User $user): Response
    {
       $this->manager->remove($user);
       $this->manager->flush();
       return $this->redirectToRoute('app_user');

        }

    }

        // return $this->render('user/index.html.twig', [
        //     'controller_name' => 'UserController',
        // ]);
