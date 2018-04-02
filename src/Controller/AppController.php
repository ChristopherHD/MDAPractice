<?php
namespace App\Controller;

use App\Entity\Users;
use App\Entity\Appointments;
use App\Form\LoginType;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{
    public function index()
    {

        return $this->render('index.html.twig');
    }

	public function citas()
	{
		
        if($this->getUser()->getRoles()[0] == 'ROLE_DOC'){
			/*$appointments = $this->getDoctrine()->getRepository(Appointments::class)->findBy(
				['doctor' => $this->getUser()->getId()],
				['date' => 'ASC']
			);*/
		} else {
			$appointments = $this->getDoctrine()->getRepository(Users::class)->findByMedicList(
				$this->getUser()->getId()
			);
		}
		
		return $this->render('citas.html.twig', array(
            'appointments' => $appointments));
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

    public function addUser(Request $request, UsersRepository $ur)
    {
        $error = null;
        $user= new Users();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $error = $ur->addUser($user);
            if($error==null){
                return $this->redirectToRoute('index');
            }else{
                $form->addError(new FormError('Exception: '.$error));
            }
        }

        return $this->render('adduser.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
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