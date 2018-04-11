<?php
namespace App\Controller;

use App\Entity\Users;
use App\Form\LoginType;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AppController extends Controller
{
    public function index()
    {
        return $this->render('index.html.twig');
    }

    public function login(AuthenticationUtils $authenticationUtils){
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class, ['dni'=>$lastUsername]);
        if($error !=null){
            $form->addError(new FormError($error->getMessageKey()));
        }
        return $this->render('login.html.twig', array(
            'form' => $form->createView(),
            'error'=> $error,
        ));
    }

    public function addUser(Request $request, UsersRepository $ur, UserPasswordEncoderInterface $passwordEncoder)
    {
        $error = null;
        $user= new Users();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $error = $ur->addUser($user);

            if($error==null){
                return $this->redirectToRoute('index');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('adduser.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function test()
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