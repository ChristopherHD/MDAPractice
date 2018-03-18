<?php
namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function index()
    {

        return $this->render('index.html.twig');
    }
    public function db_test()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new Users();
        $user->setDni('5345fdh');
        $user->setSocialSecurityNumber('jh34uh65');
        $user->setPhone('bh346');
        $user->setBirthdate(new \DateTime('NOW'));
        $user->setPassword('pepe');
        $user->setName('pepe');

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
            'name' => $user_s->getName(),

        ));
    }
}