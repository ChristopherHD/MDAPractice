<?php
namespace App\Controller;

use App\Entity\Users;
use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function index()
    {

        return $this->render('index.html.twig');
    }

    public function login(){
        if($this->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute('index');
        }
        $user= new Users();
        $form = $this->createForm(LoginType::class, $user);
        /*
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $user = $form->getData();
        }
        */
        return $this->render('login.html.twig', array(
            'form' => $form->createView(),
            'name' => $form->getName(),
        ));
    }

    public function addUser()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $user->setDni('5345fdh');
        $user->setSocialSecurityNumber('jh34uh65');
        $user->setPhone('bh346');
        $user->setBirthdate(new \DateTime('NOW'));
        $user->setPassword('pepe');
        $user->setUsername('pepe');

        $entityManager->persist($user);
        $entityManager->flush();

        $user_s = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($user->getId());

        if (!$user_s) {
            throw $this->createNotFoundException(
                'No product found for id '.$user->getId()
            );
        }

        return $this->render('dbtest.html.twig', array(
            'name' => $user_s->getUsername(),

        ));
    }
}